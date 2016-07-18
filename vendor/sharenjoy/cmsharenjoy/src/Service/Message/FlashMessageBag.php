<?php namespace Sharenjoy\Cmsharenjoy\Service\Message;

use Illuminate\Support\MessageBag;
use Illuminate\Session\Store;
use Response;

class FlashMessageBag extends MessageBag {

    protected $session_key = 'flash_messages';
    protected $session;

    public function __construct(Store $session, $messages = array())
    {
        $this->session = $session;

        if ($session->has($this->session_key))
        {
            $messages = array_merge_recursive(
                $session->get($this->session_key),
                $messages
            );
        }

        parent::__construct($messages);
    }

    public function flash()
    {
        $this->session->flash($this->session_key, $this->messages);
        return $this;
    }

    protected function mergeMessage($type, $messages)
    {
        if (is_array($messages))
        {
            foreach ($messages as $message)
            {
                $this->merge([$type => $message])->flash();
            }
        }
        elseif (is_string($messages))
        {
            $this->merge([$type => $messages])->flash();
        }
    }

    /**
     * Output some message and status the format is json
     * @param  string $status  success, error, warning
     * @param  string $message This is message wants to output
     * @param  mixed  $date
     * @return Response
     */
    public function json($status, $message = null, $data = null)
    {
        switch ($status)
        {
            case 200:
                $content = [
                    'title'   => pick_trans('success'),
                    'message' => $message ?: 'OK',
                    'data'    => $data
                ];
                break;

            case 201:
                $content = [
                    'title'   => pick_trans('success'),
                    'message' => $message ?: 'Created',
                    'data'    => $data
                ];
                break;

            case 400:
                $content = [
                    'error' => [
                        'title'   => pick_trans('fail'),
                        'message' => $message ?: 'Bad Request'
                    ]
                ];
                break;

            case 404:
                $content = [
                    'error' => [
                        'title'   => pick_trans('fail'),
                        'message' => $message ?: 'Not found'
                    ]
                ];
                break;

            default:
                throw new \InvalidArgumentException("The status code {$status} that you pass doesn't match.");
                break;
        }

        return Response::json($content, $status);
    }

    public function __call($name, $args)
    {
        if (count($args) === 1)
        {
            $this->mergeMessage($name, $args[0]);
        }
        else
        {
            throw new \InvalidArgumentException("It doesn't have right arguments");
        }
    }
}
