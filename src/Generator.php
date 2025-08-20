<?php

namespace Ucscode\Bs5AutoCss;

class Generator
{
    private array $vars = [];

    private array $media = [
        '' => null,
        'sm' => '@media (min-width:576px)',
        'md' => '@media (min-width:768px)',
        'lg' => '@media (min-width:992px)',
        'xl' => '@media (min-width:1200px)',
        'xxl' => '@media (min-width:1400px)',
    ];
    
    private array $style = [];

    /**
     * Generator constructor.
     *
     * Initializes the responsive CSS generator with configurable options for the
     * CSS property, variable prefix, class prefix, value range, and unit.  
     * It automatically generates both the root variables and responsive utility classes.
     *
     * @param string $property          
     * The css property to target (e.g., 'font-size', 'width', 'background-color').
     * 
     * @param string $variablePrefix    
     * A custom css variable names prefix to use within ":root" (e.g., '--bs-font-', '--bs-width-').
     * 
     * @param string $classPrefix       
     * The prefix for the utility class names (e.g., 'fs-', 'w-').
     * 
     * @param array $range             
     * An array of numeric values to use as suffix for bootstrap media sizes (e.g., [25, 50, 75, 100]).  
     * This will provide classes such as: *-sm-25, *-md-25, *-sm-50, *-md-50 etc
     * 
     * @param string $unit              
     * The unit to append to each value (e.g., 'px', '%', 'rem').
     */
    public function __construct(
        protected string $property, // e.g "font-size"
        protected string $variablePrefix, // e.g "--bs-font"
        protected string $classPrefix, // e.g "fs-"
        protected array $range, // e.g [10, 20, 30...]
        protected string $unit = 'px' // e.g "%", "em", ...
    ) {
        $this->generateVars();
        $this->generateRules();
    }

    public function generate(): string
    {
        $linearStyle = [$this->getDocblock()];
        $linearStyle[] = ":root {";

        foreach ($this->vars as $attribute) {
            $linearStyle[] = sprintf("\t%s: %s;", $attribute['name'], $attribute['value']);
        }

        $linearStyle[] = "}\n";

        foreach ($this->style as $attribute) {
            $media = $attribute['media'];

            if ($media) {
                $linearStyle[] = sprintf("\n%s {", $media);
            }

            foreach ($attribute['rules'] as $rule) {
                $linearStyle[] = $media ? "\t$rule" : $rule;
            }

            if ($media) {
                $linearStyle[] = "}";
            }
        }

        return implode("\n", $linearStyle);
    }

    private function generateVars(): void
    {
        foreach ($this->range as $val) {
            $this->vars[$val] = [
                'name' => $this->variablePrefix . $val,
                'value' => $val . (is_numeric($val) ? $this->unit : ''),
            ];
        }
    }

    private function generateRules(): void
    {
        foreach ($this->media as $size => $query) {
            foreach ($this->vars as $key => $attribute) {
                $selector = sprintf(
                    '.%s%s%s',
                    $this->classPrefix,
                    $size !== '' ? $size . '-' : '',
                    $key
                );

                $rule = sprintf("%s: var(%s) !important;", $this->property, $attribute['name']);

                $this->style[$size] ??= ['media' => $query, 'rules' => []];
                $this->style[$size]['rules'][$key] = sprintf("%s { %s }", $selector, $rule);
            }
        }
    }

    private function getDocblock(): string
    {
        return <<<EOD
        /*!
        * Responsive Utility Stylesheet
        *
        * This stylesheet dynamically generates utility classes for the CSS property `{$this->property}`.
        * Variables use the prefix `{$this->variablePrefix}`, and class names use the prefix `{$this->classPrefix}`.
        * Responsive variants are created based on Bootstrap 5 breakpoints.
        *
        * Author: Uchenna Ajah
        * Repository: https://github.com/ucscode/bs5-utility-generator
        * Version: 2.0.0
        * License: MIT
        */
        EOD;
    }
}
