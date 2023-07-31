<?php

declare(strict_types=1);

namespace Vcian\LaravelUtils\Console;

use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * @internal
 */

final class Thanks
{
    /** @var array<int, string> */
    private const FUNDING_MESSAGES = [
        '',
        '  - Star or contribute to Pest:',
        '    <options=bold>https://github.com/vcian/laravel-utils/stargazers</>',
    ];

    /** @var OutputInterface */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * Asks the user to support Pest.
     */
    public function __invoke(): void
    {
        $wantsToSupport = (new SymfonyQuestionHelper())->ask(
            new ArrayInput([]),
            $this->output,
            new ConfirmationQuestion(
                'Can you quickly <options=bold>star our GitHub repository</>? 🙏🏻',
                true,
            )
        );

        if ($wantsToSupport === true) {
            if (PHP_OS_FAMILY == 'Darwin') {
                exec('open https://github.com/vcian/laravel-utils/stargazers');
            }

            if (PHP_OS_FAMILY == 'Windows') {
                exec('start https://github.com/vcian/laravel-utils/stargazers');
            }

            if (PHP_OS_FAMILY == 'Linux') {
                exec('xdg-open https://github.com/vcian/laravel-utils/stargazers');
            }
        }

        foreach (self::FUNDING_MESSAGES as $message) {
            $this->output->writeln($message);
        }
    }
}