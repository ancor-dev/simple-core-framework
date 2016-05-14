<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

/**
 * Class Flash
 * @package core
 */
class Flash
{
    /**
     * @var array[] messages
     */
    private $messages;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        if (!isset($_SESSION['_flash_']) || !is_array($_SESSION['_flash_'])) {
            $_SESSION['_flash_'] = [];
        }

        $this->messages = &$_SESSION['_flash_'];
    } // end __construct()

    /**
     * Add new message
     *
     * @param string $type
     * @param string $text
     */
    public function add($type, $text)
    {
        if (!isset($this->messages[$type])) {
            $this->messages[$type] = [];
        }

        $this->messages[$type][] = $text;
    } // end add()

    /**
     * Get messages by category
     *
     * @param string $type
     *
     * @return string[]
     */
    public function get($type)
    {
        $msgs = Core::pick($this->messages, $type, []);
        $this->messages[$type] = [];

        return $msgs;
    } // end get()

    /**
     * Get all messages
     * @return \stdClass[]
     */
    public function getAll()
    {
        $all = [];
        foreach ($this->messages as $type => $msgs) {
            foreach ($msgs as $msg) {
                $all[] = (object) ['type' => $type, 'text' => $msg];
            }
        }

        $this->messages = [];

        return $all;
    } // end name()
}
