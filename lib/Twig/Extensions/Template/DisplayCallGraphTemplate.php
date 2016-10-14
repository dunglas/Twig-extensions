<?php

/*
 * This file is part of Twig.
 *
 * (c) 2010 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Displays the call graph (templates names and block names) in a visual way directly in the generated HTML.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
abstract class Twig_Extensions_Template_DisplayCallGraphTemplate extends Twig_Template
{
    /**
     * {@inheritdoc}
     */
    public function display(array $context, array $blocks = array())
    {
        if (!$this->isTemplateEnabled()) {
            parent::display($context, $blocks);

            return;
        }

        echo sprintf($this->getTemplateStart(), htmlspecialchars($this->getTemplateName()));
        parent::display($context, $blocks);
        echo $this->getTemplateEnd();
    }

    /**
     * {@inheritdoc}
     */
    public function displayBlock($name, array $context, array $blocks = array(), $useBlocks = true)
    {
        if (!$this->isTemplateEnabled() || !$this->isBlockEnabled($name)) {
            parent::displayBlock($name, $context, $blocks, $useBlocks);

            return;
        }

        echo sprintf($this->getBlockStart(), htmlspecialchars($name));
        parent::displayBlock($name, $context, $blocks, $useBlocks);
        echo $this->getBlockEnd();
    }

    /**
     * Checks if the call graph must be displayed for this template.
     *
     * @return bool
     */
    protected function isTemplateEnabled()
    {
        foreach ($this->getTemplateBlackList() as $prefix) {
            if (false !== strpos($this->getTemplateName(), $prefix)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if the call graph must be displayed for the given block.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function isBlockEnabled($name)
    {
        foreach ($this->getBlockBlackList() as $prefix) {
            if (false !== strpos($name, $prefix)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Delimiter for the start of a template.
     *
     * @return string
     */
    protected function getTemplateStart()
    {
        return '<div style="border: 1px solid rgba(240, 181, 24, 0.3); margin: 5px;"><span style="background-color: rgba(240, 181, 24, 0.3); color: black; font-family: monospace;">Template "%s"</span>';
    }

    /**
     * Delimiter for the end of a template.
     *
     * @return string
     */
    protected function getTemplateEnd()
    {
        return '</div>';
    }

    /**
     * The list of black listed templates.
     *
     * @return array
     */
    protected function getTemplateBlackList()
    {
        return array();
    }

    /**
     * Delimiter for the start of a block.
     *
     * @return string
     */
    protected function getBlockStart()
    {
        return '<div style="border: 1px solid rgba(100, 189, 99, 0.2); margin: 5px;"><span style="background-color: rgba(100, 189, 99, 0.2); color: black; font-family: monospace;">Block "%s"</span>';
    }

    /**
     * Delimiter for the end of a block.
     *
     * @return string
     */
    protected function getBlockEnd()
    {
        return '</div>';
    }

    /**
     * The list of black listed blocks.
     *
     * @return array
     */
    protected function getBlockBlackList()
    {
        return array();
    }
}
