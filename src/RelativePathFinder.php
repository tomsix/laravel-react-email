<?php

namespace Maantje\ReactEmail;

class RelativePathFinder
{
	public function __invoke(string $to, string $from = null): string
	{
		$from = explode('/', $this->formatPath($from ?? base_path()));
		$to = explode('/', $this->formatPath($to));

		$dotted = 0;
		$result = [];

		foreach ($from as $index => $piece)
		{
			if ($index >= count($to)) {
				$dotted++;
				continue;
			}

			if ($to[$index] === $piece) {
				continue;
			}

			$result[] = $to[$index];
			$dotted++;
		}

		$prefix = $dotted !== 0 ? str_repeat('../', $dotted): './';

		return $prefix . implode('/', array_merge($result, array_slice($to, count($from))));
	}

	protected function formatPath(string $path): string
	{
		return str_replace('\\', '/', realpath($path));
	}
}