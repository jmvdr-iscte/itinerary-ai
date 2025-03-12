<?php
namespace App\Services;

use Illuminate\Mail\Mailable;

class Email extends Mailable
{
	public array $info;

	public function __construct(array $info)
	{
		$this->info = $info;
	}

	public function build()
	{
		return $this->subject('Your Trip Route')
			->view('emails.route')
			->with([
				'info' => $this->info,
		]);
	}
}
