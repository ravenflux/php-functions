<?php declare(strict_types = 1);

namespace RavenFlux\Php;

use JetBrains\PhpStorm\Pure;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Vairogs\Component\Utils\Vairogs;
use function array_keys;
use function array_map;
use function current;
use function is_array;
use function is_numeric;
use function key;
use function sprintf;

class PhpFunctionsExtension extends AbstractExtension
{
    /**
     * @param array $functions
     * @param array $filters
     */
    public function __construct(private array $functions = [], private array $filters = [])
    {
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        $callbacks = $this->getCallbacks($this->filters);

        $mappedFilters = array_map(static function ($function, $callback) {
            return new TwigFilter($function, $callback);
        }, array_keys($callbacks), $callbacks);

        $mappedFilters[] = new TwigFilter(sprintf('%s_filter', Vairogs::RAVEN), [
            $this,
            'getFilter',
        ]);

        return $mappedFilters;
    }

    /**
     * @param array $callables
     *
     * @return array
     */
    #[Pure] private function getCallbacks(array $callables = []): array
    {
        $result = [];
        foreach ($callables as $function) {
            if (is_array($function) && !is_numeric(key($function))) {
                $callback = current($function);
                $function = key($function);
            } else {
                $callback = $function;
            }
            $result[$function] = $callback;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        $callbacks = $this->getCallbacks($this->functions);

        $mappedFunctions = array_map(static function ($function, $callback) {
            return new TwigFunction($function, $callback);
        }, array_keys($callbacks), $callbacks);

        $mappedFunctions[] = new TwigFunction(sprintf('%s_function', Vairogs::RAVEN), [
            $this,
            'getFunction',
        ]);

        return $mappedFunctions;
    }

    /**
     * @param mixed $object
     * @param string $filter
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function getFilter(mixed $object, string $filter, ...$arguments): mixed
    {
        if (!$arguments) {
            return $filter($object);
        }

        return $filter($object, ...$arguments);
    }

    /**
     * @param string $function
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function getFunction(string $function, ...$arguments): mixed
    {
        return $function(...$arguments);
    }
}
