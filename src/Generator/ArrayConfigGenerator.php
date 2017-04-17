<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ZfMetal\Generator\Generator;

/**
 * Description of ArrayConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ArrayConfigGenerator extends \Zend\Code\Generator\AbstractGenerator {

    const TYPE_ARRAY = 'array';
    const TYPE_ARRAY_SHORT = 'array_short';
    const TYPE_ARRAY_LONG = 'array_long';

    /**
     * @param mixed       $value
     * @param string      $type
     * @param string      $outputMode
     * @param null|SplArrayObject|StdlibArrayObject $constants
     */
    public function __construct(
    $value = null, $type = self::TYPE_AUTO, $outputMode = self::OUTPUT_MULTIPLE_LINE, $constants = null
    ) {
        // strict check is important here if $type = AUTO
        if ($value !== null) {
            $this->setValue($value);
        }
        if ($type !== self::TYPE_ARRAY && $type !== self::TYPE_ARRAY_SHORT && $type !== self::TYPE_ARRAY_LONG) {
            $this->setType(self::TYPE_ARRAY);
        }
        if ($outputMode !== self::OUTPUT_MULTIPLE_LINE) {
            $this->setOutputMode($outputMode);
        }
        if ($constants === null) {
            $constants = new SplArrayObject();
        } elseif (!(($constants instanceof SplArrayObject) || ($constants instanceof StdlibArrayObject))) {
            throw new InvalidArgumentException(
            '$constants must be an instance of ArrayObject or Zend\Stdlib\ArrayObject'
            );
        }
        $this->constants = $constants;
    }

    public function generate() {
        $type = $this->type;


        $isArrayType = in_array($type, [self::TYPE_ARRAY, self::TYPE_ARRAY_LONG, self::TYPE_ARRAY_SHORT]);
        
         $value = $this->value; 
        
        if ($isArrayType) {
            foreach ($value as &$curValue) {
                if ($curValue instanceof self) {
                    continue;
                }

                if (is_array($curValue)) {
                    $newType = $type;
                } else {
                    $newType = self::TYPE_AUTO;
                }

                $curValue = new self($curValue, $newType, self::OUTPUT_MULTIPLE_LINE, $this->getConstants());
            }
        }

        $output = '';

        if ($type == self::TYPE_ARRAY_SHORT) {
            $startArray = '[';
            $endArray = ']';
        } else {
            $startArray = 'array(';
            $endArray = ')';
        }

        $output .= $startArray;
        if ($this->outputMode == self::OUTPUT_MULTIPLE_LINE) {
            $output .= self::LINE_FEED . str_repeat($this->indentation, $this->arrayDepth + 1);
        }
        $outputParts = [];
        $noKeyIndex = 0;
        foreach ($value as $n => $v) {
            /* @var $v ValueGenerator */
            $v->setArrayDepth($this->arrayDepth + 1);
            $partV = $v->generate();
            $short = false;
            if (is_int($n)) {
                if ($n === $noKeyIndex) {
                    $short = true;
                    $noKeyIndex++;
                } else {
                    $noKeyIndex = max($n + 1, $noKeyIndex);
                }
            }

            if ($short) {
                $outputParts[] = $partV;
            } else {
                $outputParts[] = (is_int($n) ? $n : $n) . ' => ' . $partV;
            }
        }
        $padding = ($this->outputMode == self::OUTPUT_MULTIPLE_LINE) ? self::LINE_FEED . str_repeat($this->indentation, $this->arrayDepth + 1) : ' ';
        $output .= implode(',' . $padding, $outputParts);
        if ($this->outputMode == self::OUTPUT_MULTIPLE_LINE) {
            if (count($outputParts) > 0) {
                $output .= ',';
            }
            $output .= self::LINE_FEED . str_repeat($this->indentation, $this->arrayDepth);
        }
        $output .= $endArray;

        

        return $output;
    }
    

}
