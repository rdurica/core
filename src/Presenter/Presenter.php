<?php declare(strict_types=1);

namespace Rdurica\Core\Presenter;

use Nette\Application\AbortException;
use Nette\Application\Helpers;
use Nette\Application\UI\Presenter as NettePresenter;
use Rdurica\Core\Enum\FlashType;
use stdClass;

use function dirname;
use function is_bool;
use function is_int;
use function is_string;

/**
 * Presenter.
 *
 * @package   Rdurica\Core\Presenter
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-08
 * @codeCoverageIgnore
 */
abstract class Presenter extends NettePresenter
{
    /** @var string Name of presenter. Override this in child classes. */
    public const PRESENTER_NAME = '';

    /** @var string Default render action. */
    public const ACTION_DEFAULT = 'default';

    /**
     * Formats view template file names.
     *
     * @return string[]
     */
    public function formatTemplateFiles(): array
    {
        [, $presenter] = Helpers::splitName((string)$this->getName());
        $dir = dirname((string)static::getReflection()->getFileName());
        $dir = (string)is_dir($dir . '/Templates') ? $dir : dirname($dir);

        return [
            sprintf('%s/Templates/%s/%s.latte', $dir, $presenter, $this->view),
            sprintf('%s/Templates/%s.%s.latte', $dir, $presenter, $this->view),
        ];
    }

    /** @inheritDoc */
    public function flashMessage($message, FlashType|string $type = FlashType::INFO): stdClass
    {
        $flashType = is_string($type) ? $type : $type->value;

        return parent::flashMessage($message, $flashType);
    }

    /**
     * Log-out user and clear identity.
     *
     * @return void
     * @throws AbortException
     */
    public function handleSignOut(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            return;
        }

        $this->getUser()->logout(true);
        $this->getPresenter()->redirect(':Auth:Sign:in');
    }

    /**
     * Get request parameter value as string.
     *
     * @param string $name
     *
     * @return string|null
     */
    final public function getStringParameter(string $name): ?string
    {
        return $this->getParameter($name);
    }

    /**
     * Get request parameter value as integer.
     *
     * @param string $name
     *
     * @return int|null
     */
    final public function getIntParameter(string $name): ?int
    {
        $value = $this->getParameterValue($name, FILTER_VALIDATE_INT);

        return is_int($value) ? $value : null;
    }

    /**
     * Get request parameter value as boolean.
     *
     * @param string $name
     *
     * @return bool|null
     */
    final public function getBooleanParameter(string $name): ?bool
    {
        $value = $this->getParameterValue($name, FILTER_VALIDATE_BOOLEAN);

        return is_bool($value) ? $value : null;
    }

    /**
     * Validate and get value from request.
     *
     * @param string $parameter
     * @param int    $filter
     *
     * @return int|string|bool|null
     */
    private function getParameterValue(string $parameter, int $filter): null|int|string|bool
    {
        if ($parameter === '') {
            return null;
        }

        $param = $this->getParameter($parameter);
        $result = filter_var($param, $filter, FILTER_NULL_ON_FAILURE);

        return $result ?: null;
    }
}
