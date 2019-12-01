<?php

namespace Encore\Admin\Widgets\Navbar;

use Encore\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class FullScreen.
 *
 * @see  https://javascript.ruanyifeng.com/htmlapi/fullscreen.html
 */
class Fullscreen implements Renderable
{
    public function render()
    {
        $script = <<<'SCRIPT'
function launchFullscreen(element) {
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.msRequestFullscreen){
    element.msRequestFullscreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullScreen();
  }
}

function exitFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}

$('.nav-fullscreen').click(function () {
    if (document.fullscreenElement) {
        exitFullscreen();
    } else {
        launchFullscreen(document.body)
    }
});

SCRIPT;

        Admin::script($script);

        return <<<'EOT'
<li>
    <a href="javascript:void(0);" class="nav-fullscreen">
      <i class="fa fa-arrows-alt"></i>
    </a>
</li>
EOT;
    }
}
