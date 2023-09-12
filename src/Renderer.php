<?php

namespace Maantje\ReactEmail;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Renderer extends Process
{
    /**
     * @param string $view
     * @param array $data
     */
	private function __construct(string $view, array $data = [])
	{
		parent::__construct([
			(new ExecutableFinder())->find('npx', 'node', [
				'/usr/local/bin',
				'/opt/homebrew/bin',
			]),
			'tsx',
			realpath(__DIR__. '/../render.tsx'),
			$this->getViewPath($view),
			json_encode($data),
		], realpath(base_path()));
	}

	protected function getViewPath(string $view): string
	{
		return rtrim(config('react-email.template_directory'), '/')  . '/' .  $view;
	}

    /**
     * Calls the react-email render
     *
     * @param string $view name of the file the component is in
     * @param array $data data that will be passed as props to the component
     * @return array
     */
    public static function render(string $view, array $data): array
    {
        $process = new self($view, $data);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return json_decode($process->getOutput(), true);
    }
}
