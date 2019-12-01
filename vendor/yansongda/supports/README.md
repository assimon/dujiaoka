<h1 align="center">Supports</h1>

handle with array/config/log/guzzle etc.

## About log

### Register

#### Method 1

A application logger can extends `Yansongda\Supports\Log` and modify `createLogger` method, the method must return instance of `Monolog\Logger`.

```PHP
use Yansongda\Supports\Log;
use Monolog\Logger;

class APPLICATIONLOG extends Log
{
    /**
     * Make a default log instance.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return Logger
     */
    public static function createLogger()
    {
        $handler = new StreamHandler('./log.log');
        $handler->setFormatter(new LineFormatter("%datetime% > %level_name% > %message% %context% %extra%\n\n"));

        $logger = new Logger('yansongda.private_number');
        $logger->pushHandler($handler);

        return $logger;
    }
}
```

#### Method 2

Or, just init the log service with:

```PHP
use Yansongda\Supports\Log;

protected function registerLog()
{
    $logger = Log::createLogger($file, $identify, $level);

    Log::setLogger($logger);
}
```

### Usage

After registerLog, you can use Log service:

```PHP
use Yansongda\Supports\Log;

Log::debug('test', ['test log']);
```
