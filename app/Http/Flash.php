<?php  namespace App\Http; 

class Flash
{
    public function create($title, $message, $level, $key = 'flash_message', $btn_text = null)
    {
        return session()->flash($key, [
            'title'     => $title,
            'message'   => $message,
            'level'     => $level,
            'btn_text'  => $btn_text
        ]);
    }

    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    public function overlay($title, $message, $level = 'info', $btn_text = 'OK')
    {
        return $this->create($title, $message, $level, 'flash_message_overlay', $btn_text);
    }
}
