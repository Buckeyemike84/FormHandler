<?php
namespace FormHandler\Field;

use FormHandler\Form;

/**
 * This class will create a submit button
 */
class SubmitButton extends AbstractFormButton
{
    /**
     * The value of this button (text which is displayed)
     * @var string
     */
    protected $value;

    /**
     * SubmitButton constructor.
     * @param Form $form
     * @param string $value
     */
    public function __construct(Form &$form, $value = '')
    {
        $this->form = $form;
        $this->form->addField($this);

        $this->setValue($value);
    }

    /**
     * Return the form instance of this field
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set if this field is disabled and return the TextField reference
     *
     * @param bool $disabled
     * @return SubmitButton
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Return if this field is disabled
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set the name of the field and return the TextField reference
     *
     * @param string $name
     * @return SubmitButton
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return the name of the textfield
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the size of the field and return the TextField reference
     *
     * @param int $size
     * @return SubmitButton
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Return the size of the field
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value for this field and return the TextField reference
     *
     * @param string $value
     * @return SubmitButton
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Return the value for this field
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Return string representation of this field
     *
     * @return string
     */
    public function render()
    {
        $str = '<input type="submit"';

        if (!empty($this->name)) {
            $str .= ' name="' . $this->name . '"';
        }

        if (!empty($this->value)) {
            $str .= ' value="' . htmlentities($this->value, ENT_QUOTES, 'UTF-8') . '"';
        }

        if (!empty($this->size)) {
            $str .= ' size="' . $this->size . '"';
        }

        if ($this->disabled !== null && $this->disabled) {
            $str .= ' disabled="disabled"';
        }

        $str .= parent::render();
        $str .= ' />';

        return $str;
    }
}
