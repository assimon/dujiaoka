(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define('simple-hotkeys', ["jquery","simple-module"], function ($, SimpleModule) {
      return (root['hotkeys'] = factory($, SimpleModule));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("jquery"),require("simple-module"));
  } else {
    root.simple = root.simple || {};
    root.simple['hotkeys'] = factory(jQuery,SimpleModule);
  }
}(this, function ($, SimpleModule) {

var Hotkeys, hotkeys,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

Hotkeys = (function(superClass) {
  extend(Hotkeys, superClass);

  function Hotkeys() {
    return Hotkeys.__super__.constructor.apply(this, arguments);
  }

  Hotkeys.count = 0;

  Hotkeys.keyNameMap = {
    8: "Backspace",
    9: "Tab",
    13: "Enter",
    16: "Shift",
    17: "Control",
    18: "Alt",
    19: "Pause",
    20: "CapsLock",
    27: "Esc",
    32: "Spacebar",
    33: "PageUp",
    34: "PageDown",
    35: "End",
    36: "Home",
    37: "Left",
    38: "Up",
    39: "Right",
    40: "Down",
    45: "Insert",
    46: "Del",
    91: "Meta",
    93: "Meta",
    48: "0",
    49: "1",
    50: "2",
    51: "3",
    52: "4",
    53: "5",
    54: "6",
    55: "7",
    56: "8",
    57: "9",
    65: "A",
    66: "B",
    67: "C",
    68: "D",
    69: "E",
    70: "F",
    71: "G",
    72: "H",
    73: "I",
    74: "J",
    75: "K",
    76: "L",
    77: "M",
    78: "N",
    79: "O",
    80: "P",
    81: "Q",
    82: "R",
    83: "S",
    84: "T",
    85: "U",
    86: "V",
    87: "W",
    88: "X",
    89: "Y",
    90: "Z",
    96: "0",
    97: "1",
    98: "2",
    99: "3",
    100: "4",
    101: "5",
    102: "6",
    103: "7",
    104: "8",
    105: "9",
    106: "Multiply",
    107: "Add",
    109: "Subtract",
    110: "Decimal",
    111: "Divide",
    112: "F1",
    113: "F2",
    114: "F3",
    115: "F4",
    116: "F5",
    117: "F6",
    118: "F7",
    119: "F8",
    120: "F9",
    121: "F10",
    122: "F11",
    123: "F12",
    124: "F13",
    125: "F14",
    126: "F15",
    127: "F16",
    128: "F17",
    129: "F18",
    130: "F19",
    131: "F20",
    132: "F21",
    133: "F22",
    134: "F23",
    135: "F24",
    59: ";",
    61: "=",
    186: ";",
    187: "=",
    188: ",",
    190: ".",
    191: "/",
    192: "`",
    219: "[",
    220: "\\",
    221: "]",
    222: "'"
  };

  Hotkeys.aliases = {
    "escape": "esc",
    "delete": "del",
    "return": "enter",
    "ctrl": "control",
    "space": "spacebar",
    "ins": "insert",
    "cmd": "meta",
    "command": "meta",
    "wins": "meta",
    "windows": "meta"
  };

  Hotkeys.normalize = function(shortcut) {
    var i, j, key, keyname, keys, len;
    keys = shortcut.toLowerCase().replace(/\s+/gi, "").split("+");
    for (i = j = 0, len = keys.length; j < len; i = ++j) {
      key = keys[i];
      keys[i] = this.aliases[key] || key;
    }
    keyname = keys.pop();
    keys.sort().push(keyname);
    return keys.join("_");
  };

  Hotkeys.prototype.opts = {
    el: document
  };

  Hotkeys.prototype._init = function() {
    this.id = ++this.constructor.count;
    this._map = {};
    this._delegate = typeof this.opts.el === "string" ? document : this.opts.el;
    return $(this._delegate).on("keydown.simple-hotkeys-" + this.id, this.opts.el, (function(_this) {
      return function(e) {
        var ref;
        return (ref = _this._getHander(e)) != null ? ref.call(_this, e) : void 0;
      };
    })(this));
  };

  Hotkeys.prototype._getHander = function(e) {
    var keyname, shortcut;
    if (!(keyname = this.constructor.keyNameMap[e.which])) {
      return;
    }
    shortcut = "";
    if (e.altKey) {
      shortcut += "alt_";
    }
    if (e.ctrlKey) {
      shortcut += "control_";
    }
    if (e.metaKey) {
      shortcut += "meta_";
    }
    if (e.shiftKey) {
      shortcut += "shift_";
    }
    shortcut += keyname.toLowerCase();
    return this._map[shortcut];
  };

  Hotkeys.prototype.respondTo = function(subject) {
    if (typeof subject === 'string') {
      return this._map[this.constructor.normalize(subject)] != null;
    } else {
      return this._getHander(subject) != null;
    }
  };

  Hotkeys.prototype.add = function(shortcut, handler) {
    this._map[this.constructor.normalize(shortcut)] = handler;
    return this;
  };

  Hotkeys.prototype.remove = function(shortcut) {
    delete this._map[this.constructor.normalize(shortcut)];
    return this;
  };

  Hotkeys.prototype.destroy = function() {
    $(this._delegate).off(".simple-hotkeys-" + this.id);
    this._map = {};
    return this;
  };

  return Hotkeys;

})(SimpleModule);

hotkeys = function(opts) {
  return new Hotkeys(opts);
};

return hotkeys;

}));

