<?php

namespace Encore\Admin\Console;

use Encore\Admin\Admin;
use Encore\Admin\Facades\Admin as AdminFacade;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use MatthiasMullie\Minify;

class MinifyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:minify {--clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify the CSS and JS';

    /**
     * @var array
     */
    protected $assets = [
        'css' => [],
        'js'  => [],
    ];

    /**
     * @var array
     */
    protected $excepts = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!class_exists(Minify\Minify::class)) {
            $this->error('To use `admin:minify` command, please install [matthiasmullie/minify] first.');

            return;
        }

        if ($this->option('clear')) {
            return $this->clearMinifiedFiles();
        }

        AdminFacade::bootstrap();

        $this->loadExcepts();

        $this->minifyCSS();
        $this->minifyJS();

        $this->generateManifest();

        $this->comment('JS and CSS are successfully minified:');
        $this->line('  '.Admin::$min['js']);
        $this->line('  '.Admin::$min['css']);

        $this->line('');

        $this->comment('Manifest successfully generated:');
        $this->line('  '.Admin::$manifest);
    }

    protected function loadExcepts()
    {
        $excepts = config('admin.minify_assets.excepts', []);

        $this->excepts = array_merge($excepts, Admin::$minifyIgnores);
    }

    protected function clearMinifiedFiles()
    {
        @unlink(public_path(Admin::$manifest));
        @unlink(public_path(Admin::$min['js']));
        @unlink(public_path(Admin::$min['css']));

        $this->comment('Following files are cleared:');

        $this->line('  '.Admin::$min['js']);
        $this->line('  '.Admin::$min['css']);
        $this->line('  '.Admin::$manifest);
    }

    protected function minifyCSS()
    {
        $css = collect(array_merge(Admin::$css, Admin::baseCss()))
            ->unique()->map(function ($css) {
                if (url()->isValidUrl($css)) {
                    $this->assets['css'][] = $css;

                    return;
                }

                if (in_array($css, $this->excepts)) {
                    $this->assets['css'][] = $css;

                    return;
                }

                if (Str::contains($css, '?')) {
                    $css = substr($css, 0, strpos($css, '?'));
                }

                return public_path($css);
            })->filter();

        $minifier = new Minify\CSS();

        $minifier->add(...$css);

        $minifier->minify(public_path(Admin::$min['css']));
    }

    protected function minifyJS()
    {
        $js = collect(array_merge(Admin::$js, Admin::baseJs()))
            ->unique()->map(function ($js) {
                if (url()->isValidUrl($js)) {
                    $this->assets['js'][] = $js;

                    return;
                }

                if (in_array($js, $this->excepts)) {
                    $this->assets['js'][] = $js;

                    return;
                }

                if (Str::contains($js, '?')) {
                    $js = substr($js, 0, strpos($js, '?'));
                }

                return public_path($js);
            })->filter();

        $minifier = new Minify\JS();

        $minifier->add(...$js);

        $minifier->minify(public_path(Admin::$min['js']));
    }

    protected function generateManifest()
    {
        $min = collect(Admin::$min)->mapWithKeys(function ($path, $type) {
            return [$type => sprintf('%s?id=%s', $path, md5(uniqid()))];
        });

        array_unshift($this->assets['css'], $min['css']);
        array_unshift($this->assets['js'], $min['js']);

        $json = json_encode($this->assets, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        file_put_contents(public_path(Admin::$manifest), $json);
    }
}
