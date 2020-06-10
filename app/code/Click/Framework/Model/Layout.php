<?php

namespace Click\Framework\Model;

class Layout
{
    /**
     * @var string
     */
    public $layout;

    /**
     * @var string
     */
    protected $document;

    public const ELEMENT_DIV = 'div';

    public const ELEMENT_BLOCK = 'block';

    protected $map = [
        'html',
        'body',
        'head',
        'div',
        'p',
        'span',
        'header',
        'footer'
    ];

    /**
     * Layout constructor.
     * @param string $layout
     */
    public function __construct(string $layout)
    {
        $this->layout = '/code/app/code/Click/Framework/View/Layout/default.json';
        $this->document = '';
    }

    /**
     * @return mixed
     */
    protected function getJson()
    {
        $json = file_get_contents($this->layout);
        return json_decode($json, true);
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $json = $this->getJson();
        $document = '';
        foreach ($json as $key => $value) {
            $document .= $this->parseElement($key, $value);
        }
        return $document;
    }

    /**
     * @param array $block
     * @return false|string
     */
    public function renderBlock(array $block)
    {
        if (!isset($block['block']['model']) && !isset($block['block']['template'])) {
            die('No model or block.');
        }
        ob_start();
        $model = new $block['block']['model']();
        require_once($block['block']['template']);
        return ob_get_clean();
    }

    /**
     * @param string $element
     * @param array $data
     * @return string
     */
    private function parseElement(
        string $element,
        array $data
    ) {
        $html = "";
        if (in_array($element, $this->map)) {

            $html .= "<" . $element;
            if (!empty($data['attributes'])) {
                $html .= "";
                foreach ($data['attributes'] as $key => $value) {
                    $html .= " " . $key . '="' . $value . '"';
                }
            }
            $html .= ">";
            if (!empty($data['children'])) {
                //var_dump($data['children']); die();
                foreach ($data['children'] as $child => $data) {
                    $html .= $this->parseElement($child, $data);
                }
            }
            $html .= "</" . $element . ">";
        }
        else if (isset($data['block'])) {
            $html .= $this->renderBlock($data);
        }
        else if (is_int($element)) {
            $html .= $this->renderBlock($data);
        }
        else {
            $html .= "";
        }
        return $html;
    }
}