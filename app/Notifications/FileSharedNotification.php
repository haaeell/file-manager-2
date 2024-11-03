<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FileSharedNotification extends Notification
{
    use Queueable;

    protected $fileName;
    protected $sharerName;

    public function __construct($fileName, $sharerName)
    {
        $this->fileName = $fileName;
        $this->sharerName = $sharerName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'file_name' => $this->fileName,
            'sharer_name' => $this->sharerName,
            'message' => "File '{$this->fileName}' has been shared with you by {$this->sharerName}.",
        ];
    }
}
