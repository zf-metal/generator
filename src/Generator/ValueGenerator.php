<?php

namespace ZfMetal\Generator\Generator;

/**
 * Extends \Zend\Code\Generator\ValueGenerator
 * Override escape for handle Constant ::CLASS
 */
class ValueGenerator extends \Zend\Code\Generator\ValueGenerator {

    /**
     * Quotes value for PHP code.
     *
     * @param  string $input Raw string.
     * @param  bool $quote Whether add surrounding quotes or not.
     * @return string PHP-ready code.
     */
    public static function escape($input, $quote = true) {
        
        if (!preg_match("/CLASS|class/", $input)) {
            $output = addcslashes($input, "\\'");

            // adds quoting strings
            if ($quote) {
                $output = "'" . $output . "'";
            }
        }else{
            $output = $input;
        }

        return $output;
    }

    /**
     * @throws Exception\RuntimeException
     * @return string
     */
    public function generate() {
        $type = $this->type;

        if ($type != parent::TYPE_AUTO) {
            $type = $this->getValidatedType($type);
        }

        $value = $this->value;

        if ($type == parent::TYPE_AUTO) {
            $type = $this->getAutoDeterminedType($value);
        }

        $isArrayType = in_array($type, [parent::TYPE_ARRAY, parent::TYPE_ARRAY_LONG, parent::TYPE_ARRAY_SHORT]);

        if ($isArrayType) {
            foreach ($value as &$curValue) {
                if ($curValue instanceof parent || $curValue instanceof self) {
                    continue;
                }

                if (is_array($curValue)) {
                    $newType = $type;
                } else {
                    $newType = parent::TYPE_AUTO;
                }

                $curValue = new self($curValue, $newType, parent::OUTPUT_MULTIPLE_LINE, $this->getConstants());
            }
        }

        $output = '';

        switch ($type) {
            case parent::TYPE_BOOLEAN:
            case parent::TYPE_BOOL:
                $output .= ($value ? 'true' : 'false');
                break;
            case parent::TYPE_STRING:
                $output .= parent::escape($value);
                break;
            case parent::TYPE_NULL:
                $output .= 'null';
                break;
            case parent::TYPE_NUMBER:
            case parent::TYPE_INTEGER:
            case parent::TYPE_INT:
            case parent::TYPE_FLOAT:
            case parent::TYPE_DOUBLE:
            case parent::TYPE_CONSTANT:
                $output .= $value;
                break;
            case parent::TYPE_ARRAY:
            case parent::TYPE_ARRAY_LONG:
            case parent::TYPE_ARRAY_SHORT:
                if ($type == parent::TYPE_ARRAY_SHORT) {
                    $startArray = '[';
                    $endArray = ']';
                } else {
                    $startArray = 'array(';
                    $endArray = ')';
                }

                $output .= $startArray;
                if ($this->outputMode == parent::OUTPUT_MULTIPLE_LINE) {
                    $output .= parent::LINE_FEED . str_repeat($this->indentation, $this->arrayDepth + 1);
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
                        $outputParts[] = (is_int($n) ? $n : self::escape($n)) . ' => ' . $partV;
                    }
                }
                $padding = ($this->outputMode == parent::OUTPUT_MULTIPLE_LINE) ? parent::LINE_FEED . str_repeat($this->indentation, $this->arrayDepth + 1) : ' ';
                $output .= implode(',' . $padding, $outputParts);
                if ($this->outputMode == parent::OUTPUT_MULTIPLE_LINE) {
                    if (count($outputParts) > 0) {
                        $output .= ',';
                    }
                    $output .= parent::LINE_FEED . str_repeat($this->indentation, $this->arrayDepth);
                }
                $output .= $endArray;
                break;
            case parent::TYPE_OTHER:
            default:
                throw new \Zend\Code\Generator\Exception\RuntimeException(
                sprintf('Type "%s" is unknown or cannot be used as property default value.', get_class($value))
                );
        }

        return $output;
    }

}
