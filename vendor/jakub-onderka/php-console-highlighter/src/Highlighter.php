<?php
namespace JakubOnderka\PhpConsoleHighlighter;

use JakubOnderka\PhpConsoleColor\ConsoleColor;

class Highlighter
{
    const TOKEN_DEFAULT = 'token_default',
        TOKEN_COMMENT = 'token_comment',
        TOKEN_STRING = 'token_string',
        TOKEN_HTML = 'token_html',
        TOKEN_KEYWORD = 'token_keyword';

    const ACTUAL_LINE_MARK = 'actual_line_mark',
        LINE_NUMBER = 'line_number';

    /** @var ConsoleColor */
    private $color;

    /** @var array */
    private $defaultTheme = array(
        self::TOKEN_STRING => 'red',
        self::TOKEN_COMMENT => 'yellow',
        self::TOKEN_KEYWORD => 'green',
        self::TOKEN_DEFAULT => 'default',
        self::TOKEN_HTML => 'cyan',

        self::ACTUAL_LINE_MARK  => 'red',
        self::LINE_NUMBER => 'dark_gray',
    );

    /**
     * @param ConsoleColor $color
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    public function __construct(ConsoleColor $color)
    {
        $this->color = $color;

        foreach ($this->defaultTheme as $name => $styles) {
            if (!$this->color->hasTheme($name)) {
                $this->color->addTheme($name, $styles);
            }
        }
    }

    /**
     * @param string $source
     * @param int $lineNumber
     * @param int $linesBefore
     * @param int $linesAfter
     * @return string
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function getCodeSnippet($source, $lineNumber, $linesBefore = 2, $linesAfter = 2)
    {
        $tokenLines = $this->getHighlightedLines($source);

        $offset = $lineNumber - $linesBefore - 1;
        $offset = max($offset, 0);
        $length = $linesAfter + $linesBefore + 1;
        $tokenLines = array_slice($tokenLines, $offset, $length, $preserveKeys = true);

        $lines = $this->colorLines($tokenLines);

        return $this->lineNumbers($lines, $lineNumber);
    }

    /**
     * @param string $source
     * @return string
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function getWholeFile($source)
    {
        $tokenLines = $this->getHighlightedLines($source);
        $lines = $this->colorLines($tokenLines);
        return implode(PHP_EOL, $lines);
    }

    /**
     * @param string $source
     * @return string
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function getWholeFileWithLineNumbers($source)
    {
        $tokenLines = $this->getHighlightedLines($source);
        $lines = $this->colorLines($tokenLines);
        return $this->lineNumbers($lines);
    }

    /**
     * @param string $source
     * @return array
     */
    private function getHighlightedLines($source)
    {
        $source = str_replace(array("\r\n", "\r"), "\n", $source);
        $tokens = $this->tokenize($source);
        return $this->splitToLines($tokens);
    }

    /**
     * @param string $source
     * @return array
     */
    private function tokenize($source)
    {
        $tokens = token_get_all($source);

        $output = array();
        $currentType = null;
        $buffer = '';

        foreach ($tokens as $token) {
            if (is_array($token)) {
                switch ($token[0]) {
                    case T_WHITESPACE:
                        break;

                    case T_OPEN_TAG:
                    case T_OPEN_TAG_WITH_ECHO:
                    case T_CLOSE_TAG:
                    case T_STRING:
                    case T_VARIABLE:

                    // Constants
                    case T_DIR:
                    case T_FILE:
                    case T_METHOD_C:
                    case T_DNUMBER:
                    case T_LNUMBER:
                    case T_NS_C:
                    case T_LINE:
                    case T_CLASS_C:
                    case T_FUNC_C:
                    case T_TRAIT_C:
                        $newType = self::TOKEN_DEFAULT;
                        break;

                    case T_COMMENT:
                    case T_DOC_COMMENT:
                        $newType = self::TOKEN_COMMENT;
                        break;

                    case T_ENCAPSED_AND_WHITESPACE:
                    case T_CONSTANT_ENCAPSED_STRING:
                        $newType = self::TOKEN_STRING;
                        break;

                    case T_INLINE_HTML:
                        $newType = self::TOKEN_HTML;
                        break;

                    default:
                        $newType = self::TOKEN_KEYWORD;
                }
            } else {
                $newType = $token === '"' ? self::TOKEN_STRING : self::TOKEN_KEYWORD;
            }

            if ($currentType === null) {
                $currentType = $newType;
            }

            if ($currentType !== $newType) {
                $output[] = array($currentType, $buffer);
                $buffer = '';
                $currentType = $newType;
            }

            $buffer .= is_array($token) ? $token[1] : $token;
        }

        if (isset($newType)) {
            $output[] = array($newType, $buffer);
        }

        return $output;
    }

    /**
     * @param array $tokens
     * @return array
     */
    private function splitToLines(array $tokens)
    {
        $lines = array();

        $line = array();
        foreach ($tokens as $token) {
            foreach (explode("\n", $token[1]) as $count => $tokenLine) {
                if ($count > 0) {
                    $lines[] = $line;
                    $line = array();
                }

                if ($tokenLine === '') {
                    continue;
                }

                $line[] = array($token[0], $tokenLine);
            }
        }

        $lines[] = $line;

        return $lines;
    }

    /**
     * @param array $tokenLines
     * @return array
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     * @throws \InvalidArgumentException
     */
    private function colorLines(array $tokenLines)
    {
        $lines = array();
        foreach ($tokenLines as $lineCount => $tokenLine) {
            $line = '';
            foreach ($tokenLine as $token) {
                list($tokenType, $tokenValue) = $token;
                if ($this->color->hasTheme($tokenType)) {
                    $line .= $this->color->apply($tokenType, $tokenValue);
                } else {
                    $line .= $tokenValue;
                }
            }
            $lines[$lineCount] = $line;
        }

        return $lines;
    }

    /**
     * @param array $lines
     * @param null|int $markLine
     * @return string
     * @throws \JakubOnderka\PhpConsoleColor\InvalidStyleException
     */
    private function lineNumbers(array $lines, $markLine = null)
    {
        end($lines);
        $lineStrlen = strlen(key($lines) + 1);

        $snippet = '';
        foreach ($lines as $i => $line) {
            if ($markLine !== null) {
                $snippet .= ($markLine === $i + 1 ? $this->color->apply(self::ACTUAL_LINE_MARK, '  > ') : '    ');
            }

            $snippet .= $this->color->apply(self::LINE_NUMBER, str_pad($i + 1, $lineStrlen, ' ', STR_PAD_LEFT) . '| ');
            $snippet .= $line . PHP_EOL;
        }

        return $snippet;
    }
}