<?php  namespace App\Http; 

class Flash
{
    /**
     * Create a flash message
     *
     * @param $title
     * @param $message
     * @param $level
     * @param string $key
     * @param null $btn_text
     * @return void
     */
    public function create($title, $message, $level, $key = 'flash_message', $btn_text = null)
    {
        return session()->flash($key, [
            'title'     => $title,
            'message'   => $message,
            'level'     => $level,
            'btn_text'  => $btn_text
        ]);
    }

    /**
     * Create an info notification
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    /**
     * Create an success notification
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    /**
     * Create an error notification
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    /**
     * Create an overlay notification
     *
     * @param string $title
     * @param string $message
     * @param string $level
     * @param string $btn_text
     * @return void
     */
    public function overlay($title, $message, $level = 'info', $btn_text = 'OK')
    {
        return $this->create($title, $message, $level, 'flash_message_overlay', $btn_text);
    }
}
