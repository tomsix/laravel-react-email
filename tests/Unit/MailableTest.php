<?php

use Illuminate\Mail\Mailables\Content;
use Maantje\ReactEmail\ReactMailable;

it('renders the html and text from react-email', function () {
    (new class extends ReactMailable {
		public function __construct(public array $user = ['name' => 'test']) { }

		public function content(): Content
		{
			return new Content('new-user');
		}
	})
        ->assertSeeInHtml(EXPECTED_HTML, false)
        ->assertSeeInText('Hello from react email, test');
});

const EXPECTED_HTML = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <p data-id="react-email-text" style="font-size:14px;line-height:24px;margin:16px 0">Hello from react email, test</p>

</html>
HTML;


