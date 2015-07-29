<<<<<<< HEAD
<?php
/**
 * Smarty Internal Plugin Compile Block
 *
 * Compiles the {block}{/block} tags
 *
 * @package Smarty
 * @subpackage Compiler
 * @author Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Block Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Block extends Smarty_Internal_CompileBase {

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $required_attributes = array('name');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $shorttag_order = array('name', 'hide');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $optional_attributes = array('hide');

    /**
     * Compiles code for the {block} tag
     *
     * @param array  $args     array with attributes from parser
     * @param object $compiler compiler object
     * @return boolean true
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $save = array($_attr, $compiler->parser->current_buffer, $compiler->nocache, $compiler->smarty->merge_compiled_includes);
        $this->openTag($compiler, 'block', $save);
        if ($_attr['nocache'] == true) {
            $compiler->nocache = true;
        }
        // set flag for {block} tag
        $compiler->inheritance = true;
        // must merge includes
        $compiler->smarty->merge_compiled_includes = true;

        $compiler->parser->current_buffer = new _smarty_template_buffer($compiler->parser);
        $compiler->has_code = false;
        return true;
    }

    /**
     * Save or replace child block source by block name during parsing
     *
     * @param string $block_content     block source content
     * @param string $block_tag         opening block tag
     * @param object $template          template object
     * @param string $filepath          filepath of template source
     */
    public static function saveBlockData($block_content, $block_tag, $template, $filepath)
    {
        $_rdl = preg_quote($template->smarty->right_delimiter);
        $_ldl = preg_quote($template->smarty->left_delimiter);

        if (0 == preg_match("!({$_ldl}block\s+)(name=)?(\w+|'.*'|\".*\")(\s*?)?((append|prepend|nocache)?(\s*)?(hide)?)?(\s*{$_rdl})!", $block_tag, $_match)) {
            $error_text = 'Syntax Error in template "' . $template->source->filepath . '"   "' . htmlspecialchars($block_tag) . '" illegal options';
            throw new SmartyCompilerException($error_text);
        } else {
            $_name = trim($_match[3], '\'"');
            if ($_match[8] != 'hide' || isset($template->block_data[$_name])) {        // replace {$smarty.block.child}
                if (strpos($block_content, $template->smarty->left_delimiter . '$smarty.block.child' . $template->smarty->right_delimiter) !== false) {
                    if (isset($template->block_data[$_name])) {
                        $block_content = str_replace($template->smarty->left_delimiter . '$smarty.block.child' . $template->smarty->right_delimiter,
                        $template->block_data[$_name]['source'], $block_content);
                        unset($template->block_data[$_name]);
                    } else {
                        $block_content = str_replace($template->smarty->left_delimiter . '$smarty.block.child' . $template->smarty->right_delimiter,
                        '', $block_content);
                    }
                }
                if (isset($template->block_data[$_name])) {
                    if (strpos($template->block_data[$_name]['source'], '%%%%SMARTY_PARENT%%%%') !== false) {
                        $template->block_data[$_name]['source'] =
                        str_replace('%%%%SMARTY_PARENT%%%%', $block_content, $template->block_data[$_name]['source']);
                    } elseif ($template->block_data[$_name]['mode'] == 'prepend') {
                        $template->block_data[$_name]['source'] .= $block_content;
                    } elseif ($template->block_data[$_name]['mode'] == 'append') {
                        $template->block_data[$_name]['source'] = $block_content . $template->block_data[$_name]['source'];
                    }
                } else {
                    $template->block_data[$_name]['source'] = $block_content;
                    $template->block_data[$_name]['file'] = $filepath;
                }
                if ($_match[6] == 'append') {
                    $template->block_data[$_name]['mode'] = 'append';
                } elseif ($_match[6] == 'prepend') {
                    $template->block_data[$_name]['mode'] = 'prepend';
                } else {
                    $template->block_data[$_name]['mode'] = 'replace';
                }
            }
        }
    }

    /**
     * Compile saved child block source
     *
     * @param object $compiler  compiler object
     * @param string $_name     optional name of child block
     * @return string   compiled code of schild block
     */
    public static function compileChildBlock($compiler, $_name = null)
    {
        $_output = '';
        // if called by {$smarty.block.child} we must search the name of enclosing {block}
        if ($_name == null) {
            $stack_count = count($compiler->_tag_stack);
            while (--$stack_count >= 0) {
                if ($compiler->_tag_stack[$stack_count][0] == 'block') {
                    $_name = trim($compiler->_tag_stack[$stack_count][1][0]['name'] ,"'\"");
                    break;
                }
            }
            // flag that child is already compile by {$smarty.block.child} inclusion
            $compiler->template->block_data[$_name]['compiled'] = true;
        }
        if ($_name == null) {
            $compiler->trigger_template_error('{$smarty.block.child} used out of context', $compiler->lex->taglineno);
        }
        // undefined child?
        if (!isset($compiler->template->block_data[$_name]['source'])) {
            return '';
        }
        $_tpl = new Smarty_Internal_template ('string:' . $compiler->template->block_data[$_name]['source'], $compiler->smarty, $compiler->template, $compiler->template->cache_id,
        $compiler->template->compile_id = null, $compiler->template->caching, $compiler->template->cache_lifetime);
        $_tpl->variable_filters = $compiler->template->variable_filters;
        $_tpl->properties['nocache_hash'] = $compiler->template->properties['nocache_hash'];
        $_tpl->source->filepath = $compiler->template->block_data[$_name]['file'];
        $_tpl->allow_relative_path = true;
        if ($compiler->nocache) {
            $_tpl->compiler->forceNocache = 2;
        } else {
            $_tpl->compiler->forceNocache = 1;
        }
        $_tpl->compiler->suppressHeader = true;
        $_tpl->compiler->suppressTemplatePropertyHeader = true;
        $_tpl->compiler->suppressMergedTemplates = true;
        if (strpos($compiler->template->block_data[$_name]['source'], '%%%%SMARTY_PARENT%%%%') !== false) {
            $_output = str_replace('%%%%SMARTY_PARENT%%%%', $compiler->parser->current_buffer->to_smarty_php(), $_tpl->compiler->compileTemplate($_tpl));
        } elseif ($compiler->template->block_data[$_name]['mode'] == 'prepend') {
            $_output = $_tpl->compiler->compileTemplate($_tpl) . $compiler->parser->current_buffer->to_smarty_php();
        } elseif ($compiler->template->block_data[$_name]['mode'] == 'append') {
            $_output = $compiler->parser->current_buffer->to_smarty_php() . $_tpl->compiler->compileTemplate($_tpl);
        } elseif (!empty($compiler->template->block_data[$_name])) {
            $_output = $_tpl->compiler->compileTemplate($_tpl);
        }
        $compiler->template->properties['file_dependency'] = array_merge($compiler->template->properties['file_dependency'], $_tpl->properties['file_dependency']);
        $compiler->template->properties['function'] = array_merge($compiler->template->properties['function'], $_tpl->properties['function']);
        $compiler->merged_templates = array_merge($compiler->merged_templates, $_tpl->compiler->merged_templates);
        $compiler->template->variable_filters = $_tpl->variable_filters;
        if ($_tpl->has_nocache_code) {
            $compiler->template->has_nocache_code = true;
        }
        foreach($_tpl->required_plugins as $code => $tmp1) {
            foreach($tmp1 as $name => $tmp) {
                foreach($tmp as $type => $data) {
                    $compiler->template->required_plugins[$code][$name][$type] = $data;
                }
            }
        }
        unset($_tpl);
        return $_output;
    }

}

/**
 * Smarty Internal Plugin Compile BlockClose Class
 *
 * @package Smarty
 * @subpackage Compiler
*/
class Smarty_Internal_Compile_Blockclose extends Smarty_Internal_CompileBase {

    /**
     * Compiles code for the {/block} tag
     *
     * @param array  $args     array with attributes from parser
     * @param object $compiler compiler object
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        $compiler->has_code = true;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $saved_data = $this->closeTag($compiler, array('block'));
        $_name = trim($saved_data[0]['name'], "\"'");
        if (isset($compiler->template->block_data[$_name]) && !isset($compiler->template->block_data[$_name]['compiled'])) {
            $_output = Smarty_Internal_Compile_Block::compileChildBlock($compiler, $_name);
        } else {
            if (isset($saved_data[0]['hide']) && !isset($compiler->template->block_data[$_name]['source'])) {
                $_output = '';
            } else {
                $_output = $compiler->parser->current_buffer->to_smarty_php();
            }
            unset ($compiler->template->block_data[$_name]['compiled']);
        }
        // reset flags
        $compiler->parser->current_buffer = $saved_data[1];
        $compiler->nocache = $saved_data[2];
        $compiler->smarty->merge_compiled_includes = $saved_data[3];
        // reset flag for {block} tag
        $compiler->inheritance = false;
        // $_output content has already nocache code processed
        $compiler->suppressNocacheProcessing = true;
        return $_output;
    }

}

=======
<?php
/**
 * Smarty Internal Plugin Compile Block
 *
 * Compiles the {block}{/block} tags
 *
 * @package Smarty
 * @subpackage Compiler
 * @author Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Block Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Block extends Smarty_Internal_CompileBase {

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $required_attributes = array('name');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $shorttag_order = array('name', 'hide');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $optional_attributes = array('hide');

    /**
     * Compiles code for the {block} tag
     *
     * @param array  $args     array with attributes from parser
     * @param object $compiler compiler object
     * @return boolean true
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $save = array($_attr, $compiler->parser->current_buffer, $compiler->nocache, $compiler->smarty->merge_compiled_includes);
        $this->openTag($compiler, 'block', $save);
        if ($_attr['nocache'] == true) {
            $compiler->nocache = true;
        }
        // set flag for {block} tag
        $compiler->inheritance = true;
        // must merge includes
        $compiler->smarty->merge_compiled_includes = true;

        $compiler->parser->current_buffer = new _smarty_template_buffer($compiler->parser);
        $compiler->has_code = false;
        return true;
    }

    /**
     * Save or replace child block source by block name during parsing
     *
     * @param string $block_content     block source content
     * @param string $block_tag         opening block tag
     * @param object $template          template object
     * @param string $filepath          filepath of template source
     */
    public static function saveBlockData($block_content, $block_tag, $template, $filepath)
    {
        $_rdl = preg_quote($template->smarty->right_delimiter);
        $_ldl = preg_quote($template->smarty->left_delimiter);

        if (0 == preg_match("!({$_ldl}block\s+)(name=)?(\w+|'.*'|\".*\")(\s*?)?((append|prepend|nocache)?(\s*)?(hide)?)?(\s*{$_rdl})!", $block_tag, $_match)) {
            $error_text = 'Syntax Error in template "' . $template->source->filepath . '"   "' . htmlspecialchars($block_tag) . '" illegal options';
            throw new SmartyCompilerException($error_text);
        } else {
            $_name = trim($_match[3], '\'"');
            if ($_match[8] != 'hide' || isset($template->block_data[$_name])) {        // replace {$smarty.block.child}
                if (strpos($block_content, $template->smarty->left_delimiter . '$smarty.block.child' . $template->smarty->right_delimiter) !== false) {
                    if (isset($template->block_data[$_name])) {
                        $block_content = str_replace($template->smarty->left_delimiter . '$smarty.block.child' . $template->smarty->right_delimiter,
                        $template->block_data[$_name]['source'], $block_content);
                        unset($template->block_data[$_name]);
                    } else {
                        $block_content = str_replace($template->smarty->left_delimiter . '$smarty.block.child' . $template->smarty->right_delimiter,
                        '', $block_content);
                    }
                }
                if (isset($template->block_data[$_name])) {
                    if (strpos($template->block_data[$_name]['source'], '%%%%SMARTY_PARENT%%%%') !== false) {
                        $template->block_data[$_name]['source'] =
                        str_replace('%%%%SMARTY_PARENT%%%%', $block_content, $template->block_data[$_name]['source']);
                    } elseif ($template->block_data[$_name]['mode'] == 'prepend') {
                        $template->block_data[$_name]['source'] .= $block_content;
                    } elseif ($template->block_data[$_name]['mode'] == 'append') {
                        $template->block_data[$_name]['source'] = $block_content . $template->block_data[$_name]['source'];
                    }
                } else {
                    $template->block_data[$_name]['source'] = $block_content;
                    $template->block_data[$_name]['file'] = $filepath;
                }
                if ($_match[6] == 'append') {
                    $template->block_data[$_name]['mode'] = 'append';
                } elseif ($_match[6] == 'prepend') {
                    $template->block_data[$_name]['mode'] = 'prepend';
                } else {
                    $template->block_data[$_name]['mode'] = 'replace';
                }
            }
        }
    }

    /**
     * Compile saved child block source
     *
     * @param object $compiler  compiler object
     * @param string $_name     optional name of child block
     * @return string   compiled code of schild block
     */
    public static function compileChildBlock($compiler, $_name = null)
    {
        $_output = '';
        // if called by {$smarty.block.child} we must search the name of enclosing {block}
        if ($_name == null) {
            $stack_count = count($compiler->_tag_stack);
            while (--$stack_count >= 0) {
                if ($compiler->_tag_stack[$stack_count][0] == 'block') {
                    $_name = trim($compiler->_tag_stack[$stack_count][1][0]['name'] ,"'\"");
                    break;
                }
            }
            // flag that child is already compile by {$smarty.block.child} inclusion
            $compiler->template->block_data[$_name]['compiled'] = true;
        }
        if ($_name == null) {
            $compiler->trigger_template_error('{$smarty.block.child} used out of context', $compiler->lex->taglineno);
        }
        // undefined child?
        if (!isset($compiler->template->block_data[$_name]['source'])) {
            return '';
        }
        $_tpl = new Smarty_Internal_template ('string:' . $compiler->template->block_data[$_name]['source'], $compiler->smarty, $compiler->template, $compiler->template->cache_id,
        $compiler->template->compile_id = null, $compiler->template->caching, $compiler->template->cache_lifetime);
        $_tpl->variable_filters = $compiler->template->variable_filters;
        $_tpl->properties['nocache_hash'] = $compiler->template->properties['nocache_hash'];
        $_tpl->source->filepath = $compiler->template->block_data[$_name]['file'];
        $_tpl->allow_relative_path = true;
        if ($compiler->nocache) {
            $_tpl->compiler->forceNocache = 2;
        } else {
            $_tpl->compiler->forceNocache = 1;
        }
        $_tpl->compiler->suppressHeader = true;
        $_tpl->compiler->suppressTemplatePropertyHeader = true;
        $_tpl->compiler->suppressMergedTemplates = true;
        if (strpos($compiler->template->block_data[$_name]['source'], '%%%%SMARTY_PARENT%%%%') !== false) {
            $_output = str_replace('%%%%SMARTY_PARENT%%%%', $compiler->parser->current_buffer->to_smarty_php(), $_tpl->compiler->compileTemplate($_tpl));
        } elseif ($compiler->template->block_data[$_name]['mode'] == 'prepend') {
            $_output = $_tpl->compiler->compileTemplate($_tpl) . $compiler->parser->current_buffer->to_smarty_php();
        } elseif ($compiler->template->block_data[$_name]['mode'] == 'append') {
            $_output = $compiler->parser->current_buffer->to_smarty_php() . $_tpl->compiler->compileTemplate($_tpl);
        } elseif (!empty($compiler->template->block_data[$_name])) {
            $_output = $_tpl->compiler->compileTemplate($_tpl);
        }
        $compiler->template->properties['file_dependency'] = array_merge($compiler->template->properties['file_dependency'], $_tpl->properties['file_dependency']);
        $compiler->template->properties['function'] = array_merge($compiler->template->properties['function'], $_tpl->properties['function']);
        $compiler->merged_templates = array_merge($compiler->merged_templates, $_tpl->compiler->merged_templates);
        $compiler->template->variable_filters = $_tpl->variable_filters;
        if ($_tpl->has_nocache_code) {
            $compiler->template->has_nocache_code = true;
        }
        foreach($_tpl->required_plugins as $code => $tmp1) {
            foreach($tmp1 as $name => $tmp) {
                foreach($tmp as $type => $data) {
                    $compiler->template->required_plugins[$code][$name][$type] = $data;
                }
            }
        }
        unset($_tpl);
        return $_output;
    }

}

/**
 * Smarty Internal Plugin Compile BlockClose Class
 *
 * @package Smarty
 * @subpackage Compiler
*/
class Smarty_Internal_Compile_Blockclose extends Smarty_Internal_CompileBase {

    /**
     * Compiles code for the {/block} tag
     *
     * @param array  $args     array with attributes from parser
     * @param object $compiler compiler object
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        $compiler->has_code = true;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $saved_data = $this->closeTag($compiler, array('block'));
        $_name = trim($saved_data[0]['name'], "\"'");
        if (isset($compiler->template->block_data[$_name]) && !isset($compiler->template->block_data[$_name]['compiled'])) {
            $_output = Smarty_Internal_Compile_Block::compileChildBlock($compiler, $_name);
        } else {
            if (isset($saved_data[0]['hide']) && !isset($compiler->template->block_data[$_name]['source'])) {
                $_output = '';
            } else {
                $_output = $compiler->parser->current_buffer->to_smarty_php();
            }
            unset ($compiler->template->block_data[$_name]['compiled']);
        }
        // reset flags
        $compiler->parser->current_buffer = $saved_data[1];
        $compiler->nocache = $saved_data[2];
        $compiler->smarty->merge_compiled_includes = $saved_data[3];
        // reset flag for {block} tag
        $compiler->inheritance = false;
        // $_output content has already nocache code processed
        $compiler->suppressNocacheProcessing = true;
        return $_output;
    }

}

>>>>>>> vulpeess/master
?>