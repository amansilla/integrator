<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Integrator\Dependency\Console;

use Composer\IO\IOInterface;

class ComposerInputOutputAdapter implements InputOutputInterface
{
    /**
     * @var \Composer\IO\IOInterface
     */
    protected $symfonyStyle;

    /**
     * @var bool
     */
    protected $interactionMode = true;

    /**
     * @param \Composer\IO\IOInterface $symfonyStyle
     */
    public function __construct(IOInterface $symfonyStyle)
    {
        $this->symfonyStyle = $symfonyStyle;
    }

    /**
     * Writes a message to the output.
     *
     * @param array<string>|string $messages The message as an iterable of strings or a single string
     * @param bool $newline Whether to add a newline
     * @param int $options A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     *
     * @return void
     */
    public function write($messages, bool $newline = false, int $options = 0): void
    {
        $this->symfonyStyle->write($messages, $newline, $options);
    }

    /**
     * Writes a message to the output and adds a newline at the end.
     *
     * @param array<string>|string $messages The message as an iterable of strings or a single string
     * @param int $options A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     *
     * @return void
     */
    public function writeln($messages, int $options = 0): void
    {
        $this->symfonyStyle->write($messages, true, $options);
    }

    /**
     * Asks a question.
     *
     * @param string $question
     * @param string|null $default
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function ask(string $question, ?string $default = null, ?callable $validator = null)
    {
        if (!$this->interactionMode) {
            return $default;
        }

        return $this->symfonyStyle->ask($question, $default);
    }

    /**
     * Asks for confirmation.
     *
     * @param string $question
     * @param bool $default
     *
     * @return bool
     */
    public function confirm(string $question, bool $default = true): bool
    {
        if (!$this->interactionMode) {
            return $default;
        }

        return $this->symfonyStyle->askConfirmation($question, $default);
    }

    /**
     * Asks a choice question.
     *
     * @param string $question
     * @param array $choices
     * @param string|int|null $default
     *
     * @return mixed
     */
    public function choice(string $question, array $choices, $default = null)
    {
        if (!$this->interactionMode) {
            return $default;
        }

        return $this->symfonyStyle->select($question, $choices, (string)$default);
    }

    /**
     * @param bool $mode
     *
     * @return void
     */
    public function setIterationMode(bool $mode): void
    {
        $this->interactionMode = $mode;
    }

    /**
     * @return void
     */
    public function setNoIteration(): void
    {
        $this->setIterationMode(false);
    }
}
