<?php

namespace Ucscode\Style;

class Generator
{
    // :root { --variables: values }
    private $vars = [];

    private $media = [
        '' => null,
        'sm' => '@media (min-width:576px)',
        'md' => '@media (min-width:768px)',
        'lg' => '@media (min-width:992px)',
        'xl' => '@media (min-width:1200px)',
        'xxl' => '@media (min-width:1400px)',
    ];
    
    private $style = [];

    public function __construct(protected int $range = 100)
    {
        $this->generateVars();
        $this->generateRules();
    }

    public function generate(): string
    {
        $linearStyle = [$this->getDocblock()];
        
        $linearStyle[] = ":root {";

        foreach($this->vars as $attribute) {
            $linearStyle[] = sprintf("\t%s: %s;", $attribute['name'], $attribute['value']);
        }

        $linearStyle[] = "}\n";

        foreach($this->style as $attribute) {
            /** @var ?string */
            $media = $attribute['media'];
            
            if($media) {
                $linearStyle[] = sprintf("\n%s %s\n", $media, '{');
            }

            foreach($attribute['rules'] as $rule) {
                if(!empty($media)) {
                    $rule = "\t" . $rule;
                }
                $linearStyle[] = $rule;
            }

            if($media) {
                $linearStyle[] = "\n}";
            }
        };

        return implode("\n", $linearStyle);
    }

    private function generateVars(): void
    {
        for($x = 1; $x <= $this->range; $x++) {
            $this->vars[$x] = [
                'name' => "--ucs-fontsize-{$x}",
                'value' => "{$x}px"
            ];
        }
    }

    private function generateRules(): void
    {
        foreach($this->media as $size => $query) {

            foreach($this->vars as $index => $attribute) {
                
                $selector = sprintf(".fs-%s%s", !empty($size) ? "{$size}-" : '', $index);
                $value = sprintf("font-size: var(%s);", $attribute['name']);
                
                $this->style[$size] ??= [
                    'media' => $query,
                    'rules' => [],
                ];

                $this->style[$size]['rules'][$index] = sprintf("%s { %s }", $selector, $value);
            }

        }
    }

    private function getDocblock(): string
    {
        $docblock = "/*!
        * Responsive Font Size Stylesheet
        * 
        * This stylesheet provides a set of utility classes for responsive font sizes,
        * compatible with Bootstrap 5's breakpoints. It leverages CSS custom properties 
        * (variables) to allow easy customization and scalability of font sizes across 
        * different screen sizes.
        *
        * Features:
        * - Responsive font size classes using Bootstrap breakpoints (xs, sm, md, lg, xl, xxl).
        * - Utilizes CSS variables for flexible and maintainable font size management.
        * - Easy integration with Bootstrap 5 projects.
        * - Simple to extend with additional font sizes or custom breakpoints.
        *
        * Author: Uchenna Ajah
        * Repository: https://github.com/ucscode/bootstrap-responsive-stylesheet
        * Version: 1.0.0
        * License: MIT
        */
        ";

        return implode("\n", array_map('trim', explode("\n", $docblock)));
    }
}