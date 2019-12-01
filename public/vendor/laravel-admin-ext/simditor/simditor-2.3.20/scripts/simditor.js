(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define('simditor', ["jquery","simple-module","simple-hotkeys","simple-uploader"], function ($, SimpleModule, simpleHotkeys, simpleUploader) {
      return (root['Simditor'] = factory($, SimpleModule, simpleHotkeys, simpleUploader));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("jquery"),require("simple-module"),require("simple-hotkeys"),require("simple-uploader"));
  } else {
    root['Simditor'] = factory(jQuery,SimpleModule,simple.hotkeys,simple.uploader);
  }
}(this, function ($, SimpleModule, simpleHotkeys, simpleUploader) {

var AlignmentButton, BlockquoteButton, BoldButton, Button, Clipboard, CodeButton, CodePopover, ColorButton, FontScaleButton, Formatter, HrButton, ImageButton, ImagePopover, IndentButton, Indentation, InputManager, ItalicButton, Keystroke, LinkButton, LinkPopover, ListButton, OrderListButton, OutdentButton, Popover, Selection, Simditor, StrikethroughButton, TableButton, TitleButton, Toolbar, UnderlineButton, UndoManager, UnorderListButton, Util,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
  slice = [].slice;

Selection = (function(superClass) {
  extend(Selection, superClass);

  function Selection() {
    return Selection.__super__.constructor.apply(this, arguments);
  }

  Selection.pluginName = 'Selection';

  Selection.prototype._range = null;

  Selection.prototype._startNodes = null;

  Selection.prototype._endNodes = null;

  Selection.prototype._containerNode = null;

  Selection.prototype._nodes = null;

  Selection.prototype._blockNodes = null;

  Selection.prototype._rootNodes = null;

  Selection.prototype._init = function() {
    this.editor = this._module;
    this._selection = document.getSelection();
    this.editor.on('selectionchanged', (function(_this) {
      return function(e) {
        _this.reset();
        return _this._range = _this._selection.getRangeAt(0);
      };
    })(this));
    this.editor.on('blur', (function(_this) {
      return function(e) {
        return _this.reset();
      };
    })(this));
    return this.editor.on('focus', (function(_this) {
      return function(e) {
        _this.reset();
        return _this._range = _this._selection.getRangeAt(0);
      };
    })(this));
  };

  Selection.prototype.reset = function() {
    this._range = null;
    this._startNodes = null;
    this._endNodes = null;
    this._containerNode = null;
    this._nodes = null;
    this._blockNodes = null;
    return this._rootNodes = null;
  };

  Selection.prototype.clear = function() {
    var e;
    try {
      this._selection.removeAllRanges();
    } catch (_error) {
      e = _error;
    }
    return this.reset();
  };

  Selection.prototype.range = function(range) {
    var ffOrIE;
    if (range) {
      this.clear();
      this._selection.addRange(range);
      this._range = range;
      ffOrIE = this.editor.util.browser.firefox || this.editor.util.browser.msie;
      if (!this.editor.inputManager.focused && ffOrIE) {
        this.editor.body.focus();
      }
    } else if (!this._range && this.editor.inputManager.focused && this._selection.rangeCount) {
      this._range = this._selection.getRangeAt(0);
    }
    return this._range;
  };

  Selection.prototype.startNodes = function() {
    if (this._range) {
      this._startNodes || (this._startNodes = (function(_this) {
        return function() {
          var startNodes;
          startNodes = $(_this._range.startContainer).parentsUntil(_this.editor.body).get();
          startNodes.unshift(_this._range.startContainer);
          return $(startNodes);
        };
      })(this)());
    }
    return this._startNodes;
  };

  Selection.prototype.endNodes = function() {
    var endNodes;
    if (this._range) {
      this._endNodes || (this._endNodes = this._range.collapsed ? this.startNodes() : (endNodes = $(this._range.endContainer).parentsUntil(this.editor.body).get(), endNodes.unshift(this._range.endContainer), $(endNodes)));
    }
    return this._endNodes;
  };

  Selection.prototype.containerNode = function() {
    if (this._range) {
      this._containerNode || (this._containerNode = $(this._range.commonAncestorContainer));
    }
    return this._containerNode;
  };

  Selection.prototype.nodes = function() {
    if (this._range) {
      this._nodes || (this._nodes = (function(_this) {
        return function() {
          var nodes;
          nodes = [];
          if (_this.startNodes().first().is(_this.endNodes().first())) {
            nodes = _this.startNodes().get();
          } else {
            _this.startNodes().each(function(i, node) {
              var $endNode, $node, $nodes, endIndex, index, sharedIndex, startIndex;
              $node = $(node);
              if (_this.endNodes().index($node) > -1) {
                return nodes.push(node);
              } else if ($node.parent().is(_this.editor.body) || (sharedIndex = _this.endNodes().index($node.parent())) > -1) {
                if (sharedIndex && sharedIndex > -1) {
                  $endNode = _this.endNodes().eq(sharedIndex - 1);
                } else {
                  $endNode = _this.endNodes().last();
                }
                $nodes = $node.parent().contents();
                startIndex = $nodes.index($node);
                endIndex = $nodes.index($endNode);
                return $.merge(nodes, $nodes.slice(startIndex, endIndex).get());
              } else {
                $nodes = $node.parent().contents();
                index = $nodes.index($node);
                return $.merge(nodes, $nodes.slice(index).get());
              }
            });
            _this.endNodes().each(function(i, node) {
              var $node, $nodes, index;
              $node = $(node);
              if ($node.parent().is(_this.editor.body) || _this.startNodes().index($node.parent()) > -1) {
                nodes.push(node);
                return false;
              } else {
                $nodes = $node.parent().contents();
                index = $nodes.index($node);
                return $.merge(nodes, $nodes.slice(0, index + 1));
              }
            });
          }
          return $($.unique(nodes));
        };
      })(this)());
    }
    return this._nodes;
  };

  Selection.prototype.blockNodes = function() {
    if (!this._range) {
      return;
    }
    this._blockNodes || (this._blockNodes = (function(_this) {
      return function() {
        return _this.nodes().filter(function(i, node) {
          return _this.editor.util.isBlockNode(node);
        });
      };
    })(this)());
    return this._blockNodes;
  };

  Selection.prototype.rootNodes = function() {
    if (!this._range) {
      return;
    }
    this._rootNodes || (this._rootNodes = (function(_this) {
      return function() {
        return _this.nodes().filter(function(i, node) {
          var $parent;
          $parent = $(node).parent();
          return $parent.is(_this.editor.body) || $parent.is('blockquote');
        });
      };
    })(this)());
    return this._rootNodes;
  };

  Selection.prototype.rangeAtEndOf = function(node, range) {
    var afterLastNode, beforeLastNode, endNode, endNodeLength, lastNodeIsBr, result;
    if (range == null) {
      range = this.range();
    }
    if (!(range && range.collapsed)) {
      return;
    }
    node = $(node)[0];
    endNode = range.endContainer;
    endNodeLength = this.editor.util.getNodeLength(endNode);
    beforeLastNode = range.endOffset === endNodeLength - 1;
    lastNodeIsBr = $(endNode).contents().last().is('br');
    afterLastNode = range.endOffset === endNodeLength;
    if (!((beforeLastNode && lastNodeIsBr) || afterLastNode)) {
      return false;
    }
    if (node === endNode) {
      return true;
    } else if (!$.contains(node, endNode)) {
      return false;
    }
    result = true;
    $(endNode).parentsUntil(node).addBack().each(function(i, n) {
      var $lastChild, beforeLastbr, isLastNode, nodes;
      nodes = $(n).parent().contents().filter(function() {
        return !(this !== n && this.nodeType === 3 && !this.nodeValue);
      });
      $lastChild = nodes.last();
      isLastNode = $lastChild.get(0) === n;
      beforeLastbr = $lastChild.is('br') && $lastChild.prev().get(0) === n;
      if (!(isLastNode || beforeLastbr)) {
        result = false;
        return false;
      }
    });
    return result;
  };

  Selection.prototype.rangeAtStartOf = function(node, range) {
    var result, startNode;
    if (range == null) {
      range = this.range();
    }
    if (!(range && range.collapsed)) {
      return;
    }
    node = $(node)[0];
    startNode = range.startContainer;
    if (range.startOffset !== 0) {
      return false;
    }
    if (node === startNode) {
      return true;
    } else if (!$.contains(node, startNode)) {
      return false;
    }
    result = true;
    $(startNode).parentsUntil(node).addBack().each(function(i, n) {
      var nodes;
      nodes = $(n).parent().contents().filter(function() {
        return !(this !== n && this.nodeType === 3 && !this.nodeValue);
      });
      if (nodes.first().get(0) !== n) {
        return result = false;
      }
    });
    return result;
  };

  Selection.prototype.insertNode = function(node, range) {
    if (range == null) {
      range = this.range();
    }
    if (!range) {
      return;
    }
    node = $(node)[0];
    range.insertNode(node);
    return this.setRangeAfter(node, range);
  };

  Selection.prototype.setRangeAfter = function(node, range) {
    if (range == null) {
      range = this.range();
    }
    if (range == null) {
      return;
    }
    node = $(node)[0];
    range.setEndAfter(node);
    range.collapse(false);
    return this.range(range);
  };

  Selection.prototype.setRangeBefore = function(node, range) {
    if (range == null) {
      range = this.range();
    }
    if (range == null) {
      return;
    }
    node = $(node)[0];
    range.setEndBefore(node);
    range.collapse(false);
    return this.range(range);
  };

  Selection.prototype.setRangeAtStartOf = function(node, range) {
    if (range == null) {
      range = this.range();
    }
    node = $(node).get(0);
    range.setEnd(node, 0);
    range.collapse(false);
    return this.range(range);
  };

  Selection.prototype.setRangeAtEndOf = function(node, range) {
    var $lastNode, $node, contents, lastChild, lastChildLength, lastText, nodeLength;
    if (range == null) {
      range = this.range();
    }
    $node = $(node);
    node = $node[0];
    if (!node) {
      return;
    }
    if ($node.is('pre')) {
      contents = $node.contents();
      if (contents.length > 0) {
        lastChild = contents.last();
        lastText = lastChild.text();
        lastChildLength = this.editor.util.getNodeLength(lastChild[0]);
        if (lastText.charAt(lastText.length - 1) === '\n') {
          range.setEnd(lastChild[0], lastChildLength - 1);
        } else {
          range.setEnd(lastChild[0], lastChildLength);
        }
      } else {
        range.setEnd(node, 0);
      }
    } else {
      nodeLength = this.editor.util.getNodeLength(node);
      if (node.nodeType !== 3 && nodeLength > 0) {
        $lastNode = $(node).contents().last();
        if ($lastNode.is('br')) {
          nodeLength -= 1;
        } else if ($lastNode[0].nodeType !== 3 && this.editor.util.isEmptyNode($lastNode)) {
          $lastNode.append(this.editor.util.phBr);
          node = $lastNode[0];
          nodeLength = 0;
        }
      }
      range.setEnd(node, nodeLength);
    }
    range.collapse(false);
    return this.range(range);
  };

  Selection.prototype.deleteRangeContents = function(range) {
    var atEndOfBody, atStartOfBody, endRange, startRange;
    if (range == null) {
      range = this.range();
    }
    startRange = range.cloneRange();
    endRange = range.cloneRange();
    startRange.collapse(true);
    endRange.collapse(false);
    atStartOfBody = this.rangeAtStartOf(this.editor.body, startRange);
    atEndOfBody = this.rangeAtEndOf(this.editor.body, endRange);
    if (!range.collapsed && atStartOfBody && atEndOfBody) {
      this.editor.body.empty();
      range.setStart(this.editor.body[0], 0);
      range.collapse(true);
      this.range(range);
    } else {
      range.deleteContents();
    }
    return range;
  };

  Selection.prototype.breakBlockEl = function(el, range) {
    var $el;
    if (range == null) {
      range = this.range();
    }
    $el = $(el);
    if (!range.collapsed) {
      return $el;
    }
    range.setStartBefore($el.get(0));
    if (range.collapsed) {
      return $el;
    }
    return $el.before(range.extractContents());
  };

  Selection.prototype.save = function(range) {
    var endCaret, endRange, startCaret;
    if (range == null) {
      range = this.range();
    }
    if (this._selectionSaved) {
      return;
    }
    endRange = range.cloneRange();
    endRange.collapse(false);
    startCaret = $('<span/>').addClass('simditor-caret-start');
    endCaret = $('<span/>').addClass('simditor-caret-end');
    endRange.insertNode(endCaret[0]);
    range.insertNode(startCaret[0]);
    this.clear();
    return this._selectionSaved = true;
  };

  Selection.prototype.restore = function() {
    var endCaret, endContainer, endOffset, range, startCaret, startContainer, startOffset;
    if (!this._selectionSaved) {
      return false;
    }
    startCaret = this.editor.body.find('.simditor-caret-start');
    endCaret = this.editor.body.find('.simditor-caret-end');
    if (startCaret.length && endCaret.length) {
      startContainer = startCaret.parent();
      startOffset = startContainer.contents().index(startCaret);
      endContainer = endCaret.parent();
      endOffset = endContainer.contents().index(endCaret);
      if (startContainer[0] === endContainer[0]) {
        endOffset -= 1;
      }
      range = document.createRange();
      range.setStart(startContainer.get(0), startOffset);
      range.setEnd(endContainer.get(0), endOffset);
      startCaret.remove();
      endCaret.remove();
      this.range(range);
    } else {
      startCaret.remove();
      endCaret.remove();
    }
    this._selectionSaved = false;
    return range;
  };

  return Selection;

})(SimpleModule);

Formatter = (function(superClass) {
  extend(Formatter, superClass);

  function Formatter() {
    return Formatter.__super__.constructor.apply(this, arguments);
  }

  Formatter.pluginName = 'Formatter';

  Formatter.prototype.opts = {
    allowedTags: [],
    allowedAttributes: {},
    allowedStyles: {}
  };

  Formatter.prototype._init = function() {
    this.editor = this._module;
    this._allowedTags = $.merge(['br', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'h1', 'h2', 'h3', 'h4', 'hr'], this.opts.allowedTags);
    this._allowedAttributes = $.extend({
      img: ['src', 'alt', 'width', 'height', 'data-non-image'],
      a: ['href', 'target'],
      font: ['color'],
      code: ['class']
    }, this.opts.allowedAttributes);
    this._allowedStyles = $.extend({
      span: ['color', 'font-size'],
      b: ['color', 'font-size'],
      i: ['color', 'font-size'],
      strong: ['color', 'font-size'],
      strike: ['color', 'font-size'],
      u: ['color', 'font-size'],
      p: ['margin-left', 'text-align'],
      h1: ['margin-left', 'text-align'],
      h2: ['margin-left', 'text-align'],
      h3: ['margin-left', 'text-align'],
      h4: ['margin-left', 'text-align']
    }, this.opts.allowedStyles);
    return this.editor.body.on('click', 'a', function(e) {
      return false;
    });
  };

  Formatter.prototype.decorate = function($el) {
    if ($el == null) {
      $el = this.editor.body;
    }
    this.editor.trigger('decorate', [$el]);
    return $el;
  };

  Formatter.prototype.undecorate = function($el) {
    if ($el == null) {
      $el = this.editor.body.clone();
    }
    this.editor.trigger('undecorate', [$el]);
    return $el;
  };

  Formatter.prototype.autolink = function($el) {
    var $link, $node, findLinkNode, k, lastIndex, len, linkNodes, match, re, replaceEls, subStr, text, uri;
    if ($el == null) {
      $el = this.editor.body;
    }
    linkNodes = [];
    findLinkNode = function($parentNode) {
      return $parentNode.contents().each(function(i, node) {
        var $node, text;
        $node = $(node);
        if ($node.is('a') || $node.closest('a, pre', $el).length) {
          return;
        }
        if (!$node.is('iframe') && $node.contents().length) {
          return findLinkNode($node);
        } else if ((text = $node.text()) && /https?:\/\/|www\./ig.test(text)) {
          return linkNodes.push($node);
        }
      });
    };
    findLinkNode($el);
    re = /(https?:\/\/|www\.)[\w\-\.\?&=\/#%:,@\!\+]+/ig;
    for (k = 0, len = linkNodes.length; k < len; k++) {
      $node = linkNodes[k];
      text = $node.text();
      replaceEls = [];
      match = null;
      lastIndex = 0;
      while ((match = re.exec(text)) !== null) {
        subStr = text.substring(lastIndex, match.index);
        replaceEls.push(document.createTextNode(subStr));
        lastIndex = re.lastIndex;
        uri = /^(http(s)?:\/\/|\/)/.test(match[0]) ? match[0] : 'http://' + match[0];
        $link = $("<a href=\"" + uri + "\" rel=\"nofollow\"></a>").text(match[0]);
        replaceEls.push($link[0]);
      }
      replaceEls.push(document.createTextNode(text.substring(lastIndex)));
      $node.replaceWith($(replaceEls));
    }
    return $el;
  };

  Formatter.prototype.format = function($el) {
    var $node, blockNode, k, l, len, len1, n, node, ref, ref1;
    if ($el == null) {
      $el = this.editor.body;
    }
    if ($el.is(':empty')) {
      $el.append('<p>' + this.editor.util.phBr + '</p>');
      return $el;
    }
    ref = $el.contents();
    for (k = 0, len = ref.length; k < len; k++) {
      n = ref[k];
      this.cleanNode(n, true);
    }
    ref1 = $el.contents();
    for (l = 0, len1 = ref1.length; l < len1; l++) {
      node = ref1[l];
      $node = $(node);
      if ($node.is('br')) {
        if (typeof blockNode !== "undefined" && blockNode !== null) {
          blockNode = null;
        }
        $node.remove();
      } else if (this.editor.util.isBlockNode(node)) {
        if ($node.is('li')) {
          if (blockNode && blockNode.is('ul, ol')) {
            blockNode.append(node);
          } else {
            blockNode = $('<ul/>').insertBefore(node);
            blockNode.append(node);
          }
        } else {
          blockNode = null;
        }
      } else {
        if (!blockNode || blockNode.is('ul, ol')) {
          blockNode = $('<p/>').insertBefore(node);
        }
        blockNode.append(node);
        if (this.editor.util.isEmptyNode(blockNode)) {
          blockNode.append(this.editor.util.phBr);
        }
      }
    }
    return $el;
  };

  Formatter.prototype.cleanNode = function(node, recursive) {
    var $blockEls, $childImg, $node, $p, $td, allowedAttributes, attr, contents, isDecoration, k, l, len, len1, n, ref, ref1, text, textNode;
    $node = $(node);
    if (!($node.length > 0)) {
      return;
    }
    if ($node[0].nodeType === 3) {
      text = $node.text().replace(/(\r\n|\n|\r)/gm, '');
      if (text) {
        textNode = document.createTextNode(text);
        $node.replaceWith(textNode);
      } else {
        $node.remove();
      }
      return;
    }
    contents = $node.is('iframe') ? null : $node.contents();
    isDecoration = this.editor.util.isDecoratedNode($node);
    if ($node.is(this._allowedTags.join(',')) || isDecoration) {
      if ($node.is('a') && ($childImg = $node.find('img')).length > 0) {
        $node.replaceWith($childImg);
        $node = $childImg;
        contents = null;
      }
      if ($node.is('td') && ($blockEls = $node.find(this.editor.util.blockNodes.join(','))).length > 0) {
        $blockEls.each((function(_this) {
          return function(i, blockEl) {
            return $(blockEl).contents().unwrap();
          };
        })(this));
        contents = $node.contents();
      }
      if ($node.is('img') && $node.hasClass('uploading')) {
        $node.remove();
      }
      if (!isDecoration) {
        allowedAttributes = this._allowedAttributes[$node[0].tagName.toLowerCase()];
        ref = $.makeArray($node[0].attributes);
        for (k = 0, len = ref.length; k < len; k++) {
          attr = ref[k];
          if (attr.name === 'style') {
            continue;
          }
          if (!((allowedAttributes != null) && (ref1 = attr.name, indexOf.call(allowedAttributes, ref1) >= 0))) {
            $node.removeAttr(attr.name);
          }
        }
        this._cleanNodeStyles($node);
        if ($node.is('span')) {
          if ($node[0].attributes.length === 0) {
            $node.contents().first().unwrap();
          }
          if ($node[0].style.length === 2 && $node[0].style.color === 'rgb(51, 51, 51)' && $node[0].style.fontSize === '16px') {
            $node.contents().unwrap();
          }
        }
      }
    } else if ($node[0].nodeType === 1 && !$node.is(':empty')) {
      if ($node.is('div, article, dl, header, footer, tr')) {
        $node.append('<br/>');
        contents.first().unwrap();
      } else if ($node.is('table')) {
        $p = $('<p/>');
        $node.find('tr').each(function(i, tr) {
          return $p.append($(tr).text() + '<br/>');
        });
        $node.replaceWith($p);
        contents = null;
      } else if ($node.is('thead, tfoot')) {
        $node.remove();
        contents = null;
      } else if ($node.is('th')) {
        $td = $('<td/>').append($node.contents());
        $node.replaceWith($td);
      } else {
        contents.first().unwrap();
      }
    } else {
      $node.remove();
      contents = null;
    }
    if (recursive && (contents != null) && !$node.is('pre')) {
      for (l = 0, len1 = contents.length; l < len1; l++) {
        n = contents[l];
        this.cleanNode(n, true);
      }
    }
    return null;
  };

  Formatter.prototype._cleanNodeStyles = function($node) {
    var allowedStyles, k, len, pair, ref, ref1, style, styleStr, styles;
    styleStr = $node.attr('style');
    if (!styleStr) {
      return;
    }
    $node.removeAttr('style');
    allowedStyles = this._allowedStyles[$node[0].tagName.toLowerCase()];
    if (!(allowedStyles && allowedStyles.length > 0)) {
      return $node;
    }
    styles = {};
    ref = styleStr.split(';');
    for (k = 0, len = ref.length; k < len; k++) {
      style = ref[k];
      style = $.trim(style);
      pair = style.split(':');
      if (pair.length !== 2) {
        continue;
      }
      if (pair[0] === 'font-size' && pair[1].indexOf('px') > 0) {
        if (parseInt(pair[1], 10) < 12) {
          continue;
        }
      }
      if (ref1 = pair[0], indexOf.call(allowedStyles, ref1) >= 0) {
        styles[$.trim(pair[0])] = $.trim(pair[1]);
      }
    }
    if (Object.keys(styles).length > 0) {
      $node.css(styles);
    }
    return $node;
  };

  Formatter.prototype.clearHtml = function(html, lineBreak) {
    var container, contents, result;
    if (lineBreak == null) {
      lineBreak = true;
    }
    container = $('<div/>').append(html);
    contents = container.contents();
    result = '';
    contents.each((function(_this) {
      return function(i, node) {
        var $node, children;
        if (node.nodeType === 3) {
          return result += node.nodeValue;
        } else if (node.nodeType === 1) {
          $node = $(node);
          children = $node.is('iframe') ? null : $node.contents();
          if (children && children.length > 0) {
            result += _this.clearHtml(children);
          }
          if (lineBreak && i < contents.length - 1 && $node.is('br, p, div, li,tr, pre, address, artticle, aside, dl, figcaption, footer, h1, h2,h3, h4, header')) {
            return result += '\n';
          }
        }
      };
    })(this));
    return result;
  };

  Formatter.prototype.beautify = function($contents) {
    var uselessP;
    uselessP = function($el) {
      return !!($el.is('p') && !$el.text() && $el.children(':not(br)').length < 1);
    };
    return $contents.each(function(i, el) {
      var $el, invalid;
      $el = $(el);
      invalid = $el.is(':not(img, br, col, td, hr, [class^="simditor-"]):empty');
      if (invalid || uselessP($el)) {
        $el.remove();
      }
      return $el.find(':not(img, br, col, td, hr, [class^="simditor-"]):empty').remove();
    });
  };

  return Formatter;

})(SimpleModule);

InputManager = (function(superClass) {
  extend(InputManager, superClass);

  function InputManager() {
    return InputManager.__super__.constructor.apply(this, arguments);
  }

  InputManager.pluginName = 'InputManager';

  InputManager.prototype._modifierKeys = [16, 17, 18, 91, 93, 224];

  InputManager.prototype._arrowKeys = [37, 38, 39, 40];

  InputManager.prototype._init = function() {
    var selectAllKey, submitKey;
    this.editor = this._module;
    this.throttledValueChanged = this.editor.util.throttle((function(_this) {
      return function(params) {
        return setTimeout(function() {
          return _this.editor.trigger('valuechanged', params);
        }, 10);
      };
    })(this), 300);
    this.throttledSelectionChanged = this.editor.util.throttle((function(_this) {
      return function() {
        return _this.editor.trigger('selectionchanged');
      };
    })(this), 50);
    $(document).on('selectionchange.simditor' + this.editor.id, (function(_this) {
      return function(e) {
        var triggerEvent;
        if (!(_this.focused && !_this.editor.clipboard.pasting)) {
          return;
        }
        triggerEvent = function() {
          if (_this._selectionTimer) {
            clearTimeout(_this._selectionTimer);
            _this._selectionTimer = null;
          }
          if (_this.editor.selection._selection.rangeCount > 0) {
            return _this.throttledSelectionChanged();
          } else {
            return _this._selectionTimer = setTimeout(function() {
              _this._selectionTimer = null;
              if (_this.focused) {
                return triggerEvent();
              }
            }, 10);
          }
        };
        return triggerEvent();
      };
    })(this));
    this.editor.on('valuechanged', (function(_this) {
      return function() {
        var $rootBlocks;
        _this.lastCaretPosition = null;
        $rootBlocks = _this.editor.body.children().filter(function(i, node) {
          return _this.editor.util.isBlockNode(node);
        });
        if (_this.focused && $rootBlocks.length === 0) {
          _this.editor.selection.save();
          _this.editor.formatter.format();
          _this.editor.selection.restore();
        }
        _this.editor.body.find('hr, pre, .simditor-table').each(function(i, el) {
          var $el, formatted;
          $el = $(el);
          if ($el.parent().is('blockquote') || $el.parent()[0] === _this.editor.body[0]) {
            formatted = false;
            if ($el.next().length === 0) {
              $('<p/>').append(_this.editor.util.phBr).insertAfter($el);
              formatted = true;
            }
            if ($el.prev().length === 0) {
              $('<p/>').append(_this.editor.util.phBr).insertBefore($el);
              formatted = true;
            }
            if (formatted) {
              return _this.throttledValueChanged();
            }
          }
        });
        _this.editor.body.find('pre:empty').append(_this.editor.util.phBr);
        if (!_this.editor.util.support.onselectionchange && _this.focused) {
          return _this.throttledSelectionChanged();
        }
      };
    })(this));
    this.editor.body.on('keydown', $.proxy(this._onKeyDown, this)).on('keypress', $.proxy(this._onKeyPress, this)).on('keyup', $.proxy(this._onKeyUp, this)).on('mouseup', $.proxy(this._onMouseUp, this)).on('focus', $.proxy(this._onFocus, this)).on('blur', $.proxy(this._onBlur, this)).on('drop', $.proxy(this._onDrop, this)).on('input', $.proxy(this._onInput, this));
    if (this.editor.util.browser.firefox) {
      this.editor.hotkeys.add('cmd+left', (function(_this) {
        return function(e) {
          e.preventDefault();
          _this.editor.selection._selection.modify('move', 'backward', 'lineboundary');
          return false;
        };
      })(this));
      this.editor.hotkeys.add('cmd+right', (function(_this) {
        return function(e) {
          e.preventDefault();
          _this.editor.selection._selection.modify('move', 'forward', 'lineboundary');
          return false;
        };
      })(this));
      selectAllKey = this.editor.util.os.mac ? 'cmd+a' : 'ctrl+a';
      this.editor.hotkeys.add(selectAllKey, (function(_this) {
        return function(e) {
          var $children, firstBlock, lastBlock, range;
          $children = _this.editor.body.children();
          if (!($children.length > 0)) {
            return;
          }
          firstBlock = $children.first().get(0);
          lastBlock = $children.last().get(0);
          range = document.createRange();
          range.setStart(firstBlock, 0);
          range.setEnd(lastBlock, _this.editor.util.getNodeLength(lastBlock));
          _this.editor.selection.range(range);
          return false;
        };
      })(this));
    }
    submitKey = this.editor.util.os.mac ? 'cmd+enter' : 'ctrl+enter';
    return this.editor.hotkeys.add(submitKey, (function(_this) {
      return function(e) {
        _this.editor.sync();
        _this.editor.el.closest('form').find('button:submit').click();
        return false;
      };
    })(this));
  };

  InputManager.prototype._onFocus = function(e) {
    if (this.editor.clipboard.pasting) {
      return;
    }
    this.editor.el.addClass('focus').removeClass('error');
    this.focused = true;
    return setTimeout((function(_this) {
      return function() {
        var $blockEl, range;
        range = _this.editor.selection._selection.getRangeAt(0);
        if (range.startContainer === _this.editor.body[0]) {
          if (_this.lastCaretPosition) {
            _this.editor.undoManager.caretPosition(_this.lastCaretPosition);
          } else {
            $blockEl = _this.editor.body.children().first();
            range = document.createRange();
            _this.editor.selection.setRangeAtStartOf($blockEl, range);
          }
        }
        _this.lastCaretPosition = null;
        _this.editor.triggerHandler('focus');
        if (!_this.editor.util.support.onselectionchange) {
          return _this.throttledSelectionChanged();
        }
      };
    })(this), 0);
  };

  InputManager.prototype._onBlur = function(e) {
    var ref;
    if (this.editor.clipboard.pasting) {
      return;
    }
    this.editor.el.removeClass('focus');
    this.editor.sync();
    this.focused = false;
    this.lastCaretPosition = (ref = this.editor.undoManager.currentState()) != null ? ref.caret : void 0;
    return this.editor.triggerHandler('blur');
  };

  InputManager.prototype._onMouseUp = function(e) {
    if (!this.editor.util.support.onselectionchange) {
      return this.throttledSelectionChanged();
    }
  };

  InputManager.prototype._onKeyDown = function(e) {
    var ref, ref1;
    if (this.editor.triggerHandler(e) === false) {
      return false;
    }
    if (this.editor.hotkeys.respondTo(e)) {
      return;
    }
    if (this.editor.keystroke.respondTo(e)) {
      this.throttledValueChanged();
      return false;
    }
    if ((ref = e.which, indexOf.call(this._modifierKeys, ref) >= 0) || (ref1 = e.which, indexOf.call(this._arrowKeys, ref1) >= 0)) {
      return;
    }
    if (this.editor.util.metaKey(e) && e.which === 86) {
      return;
    }
    if (!this.editor.util.support.oninput) {
      this.throttledValueChanged(['typing']);
    }
    return null;
  };

  InputManager.prototype._onKeyPress = function(e) {
    if (this.editor.triggerHandler(e) === false) {
      return false;
    }
  };

  InputManager.prototype._onKeyUp = function(e) {
    var p, ref;
    if (this.editor.triggerHandler(e) === false) {
      return false;
    }
    if (!this.editor.util.support.onselectionchange && (ref = e.which, indexOf.call(this._arrowKeys, ref) >= 0)) {
      this.throttledValueChanged();
      return;
    }
    if ((e.which === 8 || e.which === 46) && this.editor.util.isEmptyNode(this.editor.body)) {
      this.editor.body.empty();
      p = $('<p/>').append(this.editor.util.phBr).appendTo(this.editor.body);
      this.editor.selection.setRangeAtStartOf(p);
    }
  };

  InputManager.prototype._onDrop = function(e) {
    if (this.editor.triggerHandler(e) === false) {
      return false;
    }
    return this.throttledValueChanged();
  };

  InputManager.prototype._onInput = function(e) {
    return this.throttledValueChanged(['oninput']);
  };

  return InputManager;

})(SimpleModule);

Keystroke = (function(superClass) {
  extend(Keystroke, superClass);

  function Keystroke() {
    return Keystroke.__super__.constructor.apply(this, arguments);
  }

  Keystroke.pluginName = 'Keystroke';

  Keystroke.prototype._init = function() {
    this.editor = this._module;
    this._keystrokeHandlers = {};
    return this._initKeystrokeHandlers();
  };

  Keystroke.prototype.add = function(key, node, handler) {
    key = key.toLowerCase();
    key = this.editor.hotkeys.constructor.aliases[key] || key;
    if (!this._keystrokeHandlers[key]) {
      this._keystrokeHandlers[key] = {};
    }
    return this._keystrokeHandlers[key][node] = handler;
  };

  Keystroke.prototype.respondTo = function(e) {
    var base, key, ref, result;
    key = (ref = this.editor.hotkeys.constructor.keyNameMap[e.which]) != null ? ref.toLowerCase() : void 0;
    if (!key) {
      return;
    }
    if (key in this._keystrokeHandlers) {
      result = typeof (base = this._keystrokeHandlers[key])['*'] === "function" ? base['*'](e) : void 0;
      if (!result) {
        this.editor.selection.startNodes().each((function(_this) {
          return function(i, node) {
            var handler, ref1;
            if (node.nodeType !== Node.ELEMENT_NODE) {
              return;
            }
            handler = (ref1 = _this._keystrokeHandlers[key]) != null ? ref1[node.tagName.toLowerCase()] : void 0;
            result = typeof handler === "function" ? handler(e, $(node)) : void 0;
            if (result === true || result === false) {
              return false;
            }
          };
        })(this));
      }
      if (result) {
        return true;
      }
    }
  };

  Keystroke.prototype._initKeystrokeHandlers = function() {
    var titleEnterHandler;
    if (this.editor.util.browser.safari) {
      this.add('enter', '*', (function(_this) {
        return function(e) {
          var $blockEl, $br;
          if (!e.shiftKey) {
            return;
          }
          $blockEl = _this.editor.selection.blockNodes().last();
          if ($blockEl.is('pre')) {
            return;
          }
          $br = $('<br/>');
          if (_this.editor.selection.rangeAtEndOf($blockEl)) {
            _this.editor.selection.insertNode($br);
            _this.editor.selection.insertNode($('<br/>'));
            _this.editor.selection.setRangeBefore($br);
          } else {
            _this.editor.selection.insertNode($br);
          }
          return true;
        };
      })(this));
    }
    if (this.editor.util.browser.webkit || this.editor.util.browser.msie) {
      titleEnterHandler = (function(_this) {
        return function(e, $node) {
          var $p;
          if (!_this.editor.selection.rangeAtEndOf($node)) {
            return;
          }
          $p = $('<p/>').append(_this.editor.util.phBr).insertAfter($node);
          _this.editor.selection.setRangeAtStartOf($p);
          return true;
        };
      })(this);
      this.add('enter', 'h1', titleEnterHandler);
      this.add('enter', 'h2', titleEnterHandler);
      this.add('enter', 'h3', titleEnterHandler);
      this.add('enter', 'h4', titleEnterHandler);
      this.add('enter', 'h5', titleEnterHandler);
      this.add('enter', 'h6', titleEnterHandler);
    }
    this.add('backspace', '*', (function(_this) {
      return function(e) {
        var $blockEl, $prevBlockEl, $rootBlock, isWebkit;
        $rootBlock = _this.editor.selection.rootNodes().first();
        $prevBlockEl = $rootBlock.prev();
        if ($prevBlockEl.is('hr') && _this.editor.selection.rangeAtStartOf($rootBlock)) {
          _this.editor.selection.save();
          $prevBlockEl.remove();
          _this.editor.selection.restore();
          return true;
        }
        $blockEl = _this.editor.selection.blockNodes().last();
        if ($blockEl.is('.simditor-resize-handle') && $rootBlock.is('.simditor-table')) {
          e.preventDefault();
          $rootBlock.remove();
          _this.editor.selection.setRangeAtEndOf($prevBlockEl);
        }
        if ($prevBlockEl.is('.simditor-table') && !$blockEl.is('table') && _this.editor.util.isEmptyNode($blockEl)) {
          e.preventDefault();
          $blockEl.remove();
          _this.editor.selection.setRangeAtEndOf($prevBlockEl);
        }
        isWebkit = _this.editor.util.browser.webkit;
        if (isWebkit && _this.editor.selection.rangeAtStartOf($blockEl)) {
          _this.editor.selection.save();
          _this.editor.formatter.cleanNode($blockEl, true);
          _this.editor.selection.restore();
          return null;
        }
      };
    })(this));
    this.add('enter', 'div', (function(_this) {
      return function(e, $node) {
        var $blockEl, $p;
        if ($node.is('.simditor-table')) {
          $blockEl = _this.editor.selection.blockNodes().last();
          if ($blockEl.is('.simditor-resize-handle')) {
            e.preventDefault();
            $p = $('<p/>').append(_this.editor.util.phBr).insertAfter($node);
            return _this.editor.selection.setRangeAtStartOf($p);
          }
        }
      };
    })(this));
    this.add('enter', 'li', (function(_this) {
      return function(e, $node) {
        var $cloneNode, listEl, newBlockEl, newListEl;
        $cloneNode = $node.clone();
        $cloneNode.find('ul, ol').remove();
        if (!(_this.editor.util.isEmptyNode($cloneNode) && $node.is(_this.editor.selection.blockNodes().last()))) {
          return;
        }
        listEl = $node.parent();
        if ($node.next('li').length > 0) {
          if (!_this.editor.util.isEmptyNode($node)) {
            return;
          }
          if (listEl.parent('li').length > 0) {
            newBlockEl = $('<li/>').append(_this.editor.util.phBr).insertAfter(listEl.parent('li'));
            newListEl = $('<' + listEl[0].tagName + '/>').append($node.nextAll('li'));
            newBlockEl.append(newListEl);
          } else {
            newBlockEl = $('<p/>').append(_this.editor.util.phBr).insertAfter(listEl);
            newListEl = $('<' + listEl[0].tagName + '/>').append($node.nextAll('li'));
            newBlockEl.after(newListEl);
          }
        } else {
          if (listEl.parent('li').length > 0) {
            newBlockEl = $('<li/>').insertAfter(listEl.parent('li'));
            if ($node.contents().length > 0) {
              newBlockEl.append($node.contents());
            } else {
              newBlockEl.append(_this.editor.util.phBr);
            }
          } else {
            newBlockEl = $('<p/>').append(_this.editor.util.phBr).insertAfter(listEl);
            if ($node.children('ul, ol').length > 0) {
              newBlockEl.after($node.children('ul, ol'));
            }
          }
        }
        if ($node.prev('li').length) {
          $node.remove();
        } else {
          if ($node.prev('ul').length || $node.prev('ol').length) {
            $node.remove();
          } else {
            listEl.remove();
          }
        }
        _this.editor.selection.setRangeAtStartOf(newBlockEl);
        return true;
      };
    })(this));
    this.add('enter', 'pre', (function(_this) {
      return function(e, $node) {
        var $p, breakNode, range;
        e.preventDefault();
        if (e.shiftKey) {
          $p = $('<p/>').append(_this.editor.util.phBr).insertAfter($node);
          _this.editor.selection.setRangeAtStartOf($p);
          return true;
        }
        range = _this.editor.selection.range();
        breakNode = null;
        range.deleteContents();
        if (!_this.editor.util.browser.msie && _this.editor.selection.rangeAtEndOf($node)) {
          breakNode = document.createTextNode('\n\n');
        } else {
          breakNode = document.createTextNode('\n');
        }
        range.insertNode(breakNode);
        range.setEnd(breakNode, 1);
        range.collapse(false);
        _this.editor.selection.range(range);
        return true;
      };
    })(this));
    this.add('enter', 'blockquote', (function(_this) {
      return function(e, $node) {
        var $closestBlock, range;
        $closestBlock = _this.editor.selection.blockNodes().last();
        if (!($closestBlock.is('p') && !$closestBlock.next().length && _this.editor.util.isEmptyNode($closestBlock))) {
          return;
        }
        $node.after($closestBlock);
        range = document.createRange();
        _this.editor.selection.setRangeAtStartOf($closestBlock, range);
        return true;
      };
    })(this));
    this.add('backspace', 'li', (function(_this) {
      return function(e, $node) {
        var $br, $childList, $newLi, $prevChildList, $prevNode, $textNode, isFF, range, text;
        $childList = $node.children('ul, ol');
        $prevNode = $node.prev('li');
        if (!($childList.length > 0 && $prevNode.length > 0)) {
          return false;
        }
        text = '';
        $textNode = null;
        $node.contents().each(function(i, n) {
          if (n.nodeType === 1 && /UL|OL/.test(n.nodeName)) {
            return false;
          }
          if (n.nodeType === 1 && /BR/.test(n.nodeName)) {
            return;
          }
          if (n.nodeType === 3 && n.nodeValue) {
            text += n.nodeValue;
          } else if (n.nodeType === 1) {
            text += $(n).text();
          }
          return $textNode = $(n);
        });
        isFF = _this.editor.util.browser.firefox && !$textNode.next('br').length;
        if ($textNode && text.length === 1 && isFF) {
          $br = $(_this.editor.util.phBr).insertAfter($textNode);
          $textNode.remove();
          _this.editor.selection.setRangeBefore($br);
          return true;
        } else if (text.length > 0) {
          return false;
        }
        range = document.createRange();
        $prevChildList = $prevNode.children('ul, ol');
        if ($prevChildList.length > 0) {
          $newLi = $('<li/>').append(_this.editor.util.phBr).appendTo($prevChildList);
          $prevChildList.append($childList.children('li'));
          $node.remove();
          _this.editor.selection.setRangeAtEndOf($newLi, range);
        } else {
          _this.editor.selection.setRangeAtEndOf($prevNode, range);
          $prevNode.append($childList);
          $node.remove();
          _this.editor.selection.range(range);
        }
        return true;
      };
    })(this));
    this.add('backspace', 'pre', (function(_this) {
      return function(e, $node) {
        var $newNode, codeStr, range;
        if (!_this.editor.selection.rangeAtStartOf($node)) {
          return;
        }
        codeStr = $node.html().replace('\n', '<br/>') || _this.editor.util.phBr;
        $newNode = $('<p/>').append(codeStr).insertAfter($node);
        $node.remove();
        range = document.createRange();
        _this.editor.selection.setRangeAtStartOf($newNode, range);
        return true;
      };
    })(this));
    return this.add('backspace', 'blockquote', (function(_this) {
      return function(e, $node) {
        var $firstChild, range;
        if (!_this.editor.selection.rangeAtStartOf($node)) {
          return;
        }
        $firstChild = $node.children().first().unwrap();
        range = document.createRange();
        _this.editor.selection.setRangeAtStartOf($firstChild, range);
        return true;
      };
    })(this));
  };

  return Keystroke;

})(SimpleModule);

UndoManager = (function(superClass) {
  extend(UndoManager, superClass);

  function UndoManager() {
    return UndoManager.__super__.constructor.apply(this, arguments);
  }

  UndoManager.pluginName = 'UndoManager';

  UndoManager.prototype._index = -1;

  UndoManager.prototype._capacity = 20;

  UndoManager.prototype._startPosition = null;

  UndoManager.prototype._endPosition = null;

  UndoManager.prototype._init = function() {
    var redoShortcut, undoShortcut;
    this.editor = this._module;
    this._stack = [];
    if (this.editor.util.os.mac) {
      undoShortcut = 'cmd+z';
      redoShortcut = 'shift+cmd+z';
    } else if (this.editor.util.os.win) {
      undoShortcut = 'ctrl+z';
      redoShortcut = 'ctrl+y';
    } else {
      undoShortcut = 'ctrl+z';
      redoShortcut = 'shift+ctrl+z';
    }
    this.editor.hotkeys.add(undoShortcut, (function(_this) {
      return function(e) {
        e.preventDefault();
        _this.undo();
        return false;
      };
    })(this));
    this.editor.hotkeys.add(redoShortcut, (function(_this) {
      return function(e) {
        e.preventDefault();
        _this.redo();
        return false;
      };
    })(this));
    this.throttledPushState = this.editor.util.throttle((function(_this) {
      return function() {
        return _this._pushUndoState();
      };
    })(this), 2000);
    this.editor.on('valuechanged', (function(_this) {
      return function(e, src) {
        if (src === 'undo' || src === 'redo') {
          return;
        }
        return _this.throttledPushState();
      };
    })(this));
    this.editor.on('selectionchanged', (function(_this) {
      return function(e) {
        _this.resetCaretPosition();
        return _this.update();
      };
    })(this));
    this.editor.on('focus', (function(_this) {
      return function(e) {
        if (_this._stack.length === 0) {
          return _this._pushUndoState();
        }
      };
    })(this));
    return this.editor.on('blur', (function(_this) {
      return function(e) {
        return _this.resetCaretPosition();
      };
    })(this));
  };

  UndoManager.prototype.resetCaretPosition = function() {
    this._startPosition = null;
    return this._endPosition = null;
  };

  UndoManager.prototype.startPosition = function() {
    if (this.editor.selection._range) {
      this._startPosition || (this._startPosition = this._getPosition('start'));
    }
    return this._startPosition;
  };

  UndoManager.prototype.endPosition = function() {
    if (this.editor.selection._range) {
      this._endPosition || (this._endPosition = (function(_this) {
        return function() {
          var range;
          range = _this.editor.selection.range();
          if (range.collapsed) {
            return _this._startPosition;
          }
          return _this._getPosition('end');
        };
      })(this)());
    }
    return this._endPosition;
  };

  UndoManager.prototype._pushUndoState = function() {
    var caret;
    if (this.editor.triggerHandler('pushundostate') === false) {
      return;
    }
    caret = this.caretPosition();
    if (!caret.start) {
      return;
    }
    this._index += 1;
    this._stack.length = this._index;
    this._stack.push({
      html: this.editor.body.html(),
      caret: this.caretPosition()
    });
    if (this._stack.length > this._capacity) {
      this._stack.shift();
      return this._index -= 1;
    }
  };

  UndoManager.prototype.currentState = function() {
    if (this._stack.length && this._index > -1) {
      return this._stack[this._index];
    } else {
      return null;
    }
  };

  UndoManager.prototype.undo = function() {
    var state;
    if (this._index < 1 || this._stack.length < 2) {
      return;
    }
    this.editor.hidePopover();
    this._index -= 1;
    state = this._stack[this._index];
    this.editor.body.get(0).innerHTML = state.html;
    this.caretPosition(state.caret);
    this.editor.body.find('.selected').removeClass('selected');
    this.editor.sync();
    return this.editor.trigger('valuechanged', ['undo']);
  };

  UndoManager.prototype.redo = function() {
    var state;
    if (this._index < 0 || this._stack.length < this._index + 2) {
      return;
    }
    this.editor.hidePopover();
    this._index += 1;
    state = this._stack[this._index];
    this.editor.body.get(0).innerHTML = state.html;
    this.caretPosition(state.caret);
    this.editor.body.find('.selected').removeClass('selected');
    this.editor.sync();
    return this.editor.trigger('valuechanged', ['redo']);
  };

  UndoManager.prototype.update = function() {
    var currentState;
    currentState = this.currentState();
    if (!currentState) {
      return;
    }
    currentState.html = this.editor.body.html();
    return currentState.caret = this.caretPosition();
  };

  UndoManager.prototype._getNodeOffset = function(node, index) {
    var $parent, merging, offset;
    if ($.isNumeric(index)) {
      $parent = $(node);
    } else {
      $parent = $(node).parent();
    }
    offset = 0;
    merging = false;
    $parent.contents().each(function(i, child) {
      if (node === child || (index === i && i === 0)) {
        return false;
      }
      if (child.nodeType === Node.TEXT_NODE) {
        if (!merging && child.nodeValue.length > 0) {
          offset += 1;
          merging = true;
        }
      } else {
        offset += 1;
        merging = false;
      }
      if (index - 1 === i) {
        return false;
      }
      return null;
    });
    return offset;
  };

  UndoManager.prototype._getPosition = function(type) {
    var $nodes, node, nodes, offset, position, prevNode, range;
    if (type == null) {
      type = 'start';
    }
    range = this.editor.selection.range();
    offset = range[type + "Offset"];
    $nodes = this.editor.selection[type + "Nodes"]();
    node = $nodes.first()[0];
    if (node.nodeType === Node.TEXT_NODE) {
      prevNode = node.previousSibling;
      while (prevNode && prevNode.nodeType === Node.TEXT_NODE) {
        node = prevNode;
        offset += this.editor.util.getNodeLength(prevNode);
        prevNode = prevNode.previousSibling;
      }
      nodes = $nodes.get();
      nodes[0] = node;
      $nodes = $(nodes);
    } else {
      offset = this._getNodeOffset(node, offset);
    }
    position = [offset];
    $nodes.each((function(_this) {
      return function(i, node) {
        return position.unshift(_this._getNodeOffset(node));
      };
    })(this));
    return position;
  };

  UndoManager.prototype._getNodeByPosition = function(position) {
    var child, childNodes, i, k, len, node, offset, ref;
    node = this.editor.body[0];
    ref = position.slice(0, position.length - 1);
    for (i = k = 0, len = ref.length; k < len; i = ++k) {
      offset = ref[i];
      childNodes = node.childNodes;
      if (offset > childNodes.length - 1) {
        if (i === position.length - 2 && $(node).is(':empty')) {
          child = document.createTextNode('');
          node.appendChild(child);
          childNodes = node.childNodes;
        } else {
          node = null;
          break;
        }
      }
      node = childNodes[offset];
    }
    return node;
  };

  UndoManager.prototype.caretPosition = function(caret) {
    var endContainer, endOffset, range, startContainer, startOffset;
    if (!caret) {
      range = this.editor.selection.range();
      caret = this.editor.inputManager.focused && (range != null) ? {
        start: this.startPosition(),
        end: this.endPosition(),
        collapsed: range.collapsed
      } : {};
      return caret;
    } else {
      if (!caret.start) {
        return;
      }
      startContainer = this._getNodeByPosition(caret.start);
      startOffset = caret.start[caret.start.length - 1];
      if (caret.collapsed) {
        endContainer = startContainer;
        endOffset = startOffset;
      } else {
        endContainer = this._getNodeByPosition(caret.end);
        endOffset = caret.start[caret.start.length - 1];
      }
      if (!startContainer || !endContainer) {
        if (typeof console !== "undefined" && console !== null) {
          if (typeof console.warn === "function") {
            console.warn('simditor: invalid caret state');
          }
        }
        return;
      }
      range = document.createRange();
      range.setStart(startContainer, startOffset);
      range.setEnd(endContainer, endOffset);
      return this.editor.selection.range(range);
    }
  };

  return UndoManager;

})(SimpleModule);

Util = (function(superClass) {
  extend(Util, superClass);

  function Util() {
    return Util.__super__.constructor.apply(this, arguments);
  }

  Util.pluginName = 'Util';

  Util.prototype._init = function() {
    this.editor = this._module;
    if (this.browser.msie && this.browser.version < 11) {
      return this.phBr = '';
    }
  };

  Util.prototype.phBr = '<br/>';

  Util.prototype.os = (function() {
    var os;
    os = {};
    if (/Mac/.test(navigator.appVersion)) {
      os.mac = true;
    } else if (/Linux/.test(navigator.appVersion)) {
      os.linux = true;
    } else if (/Win/.test(navigator.appVersion)) {
      os.win = true;
    } else if (/X11/.test(navigator.appVersion)) {
      os.unix = true;
    }
    if (/Mobi/.test(navigator.appVersion)) {
      os.mobile = true;
    }
    return os;
  })();

  Util.prototype.browser = (function() {
    var chrome, edge, firefox, ie, ref, ref1, ref2, ref3, ref4, safari, ua;
    ua = navigator.userAgent;
    ie = /(msie|trident)/i.test(ua);
    chrome = /chrome|crios/i.test(ua);
    safari = /safari/i.test(ua) && !chrome;
    firefox = /firefox/i.test(ua);
    edge = /edge/i.test(ua);
    if (ie) {
      return {
        msie: true,
        version: ((ref = ua.match(/(msie |rv:)(\d+(\.\d+)?)/i)) != null ? ref[2] : void 0) * 1
      };
    } else if (edge) {
      return {
        edge: true,
        webkit: true,
        version: ((ref1 = ua.match(/edge\/(\d+(\.\d+)?)/i)) != null ? ref1[1] : void 0) * 1
      };
    } else if (chrome) {
      return {
        webkit: true,
        chrome: true,
        version: ((ref2 = ua.match(/(?:chrome|crios)\/(\d+(\.\d+)?)/i)) != null ? ref2[1] : void 0) * 1
      };
    } else if (safari) {
      return {
        webkit: true,
        safari: true,
        version: ((ref3 = ua.match(/version\/(\d+(\.\d+)?)/i)) != null ? ref3[1] : void 0) * 1
      };
    } else if (firefox) {
      return {
        mozilla: true,
        firefox: true,
        version: ((ref4 = ua.match(/firefox\/(\d+(\.\d+)?)/i)) != null ? ref4[1] : void 0) * 1
      };
    } else {
      return {};
    }
  })();

  Util.prototype.support = (function() {
    return {
      onselectionchange: (function() {
        var e, onselectionchange;
        onselectionchange = document.onselectionchange;
        if (onselectionchange !== void 0) {
          try {
            document.onselectionchange = 0;
            return document.onselectionchange === null;
          } catch (_error) {
            e = _error;
          } finally {
            document.onselectionchange = onselectionchange;
          }
        }
        return false;
      })(),
      oninput: (function() {
        return !/(msie|trident)/i.test(navigator.userAgent);
      })()
    };
  })();

  Util.prototype.reflow = function(el) {
    if (el == null) {
      el = document;
    }
    return $(el)[0].offsetHeight;
  };

  Util.prototype.metaKey = function(e) {
    var isMac;
    isMac = /Mac/.test(navigator.userAgent);
    if (isMac) {
      return e.metaKey;
    } else {
      return e.ctrlKey;
    }
  };

  Util.prototype.isEmptyNode = function(node) {
    var $node;
    $node = $(node);
    return $node.is(':empty') || (!$node.text() && !$node.find(':not(br, span, div)').length);
  };

  Util.prototype.isDecoratedNode = function(node) {
    return $(node).is('[class^="simditor-"]');
  };

  Util.prototype.blockNodes = ["div", "p", "ul", "ol", "li", "blockquote", "hr", "pre", "h1", "h2", "h3", "h4", "h5", "table"];

  Util.prototype.isBlockNode = function(node) {
    node = $(node)[0];
    if (!node || node.nodeType === 3) {
      return false;
    }
    return new RegExp("^(" + (this.blockNodes.join('|')) + ")$").test(node.nodeName.toLowerCase());
  };

  Util.prototype.getNodeLength = function(node) {
    node = $(node)[0];
    switch (node.nodeType) {
      case 7:
      case 10:
        return 0;
      case 3:
      case 8:
        return node.length;
      default:
        return node.childNodes.length;
    }
  };

  Util.prototype.dataURLtoBlob = function(dataURL) {
    var BlobBuilder, arrayBuffer, bb, blobArray, byteString, hasArrayBufferViewSupport, hasBlobConstructor, i, intArray, k, mimeString, ref, supportBlob;
    hasBlobConstructor = window.Blob && (function() {
      var e;
      try {
        return Boolean(new Blob());
      } catch (_error) {
        e = _error;
        return false;
      }
    })();
    hasArrayBufferViewSupport = hasBlobConstructor && window.Uint8Array && (function() {
      var e;
      try {
        return new Blob([new Uint8Array(100)]).size === 100;
      } catch (_error) {
        e = _error;
        return false;
      }
    })();
    BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
    supportBlob = hasBlobConstructor || BlobBuilder;
    if (!(supportBlob && window.atob && window.ArrayBuffer && window.Uint8Array)) {
      return false;
    }
    if (dataURL.split(',')[0].indexOf('base64') >= 0) {
      byteString = atob(dataURL.split(',')[1]);
    } else {
      byteString = decodeURIComponent(dataURL.split(',')[1]);
    }
    arrayBuffer = new ArrayBuffer(byteString.length);
    intArray = new Uint8Array(arrayBuffer);
    for (i = k = 0, ref = byteString.length; 0 <= ref ? k <= ref : k >= ref; i = 0 <= ref ? ++k : --k) {
      intArray[i] = byteString.charCodeAt(i);
    }
    mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
    if (hasBlobConstructor) {
      blobArray = hasArrayBufferViewSupport ? intArray : arrayBuffer;
      return new Blob([blobArray], {
        type: mimeString
      });
    }
    bb = new BlobBuilder();
    bb.append(arrayBuffer);
    return bb.getBlob(mimeString);
  };

  Util.prototype.throttle = function(func, wait) {
    var args, call, ctx, last, rtn, throttled, timeoutID;
    last = 0;
    timeoutID = 0;
    ctx = args = rtn = null;
    call = function() {
      timeoutID = 0;
      last = +new Date();
      rtn = func.apply(ctx, args);
      ctx = null;
      return args = null;
    };
    throttled = function() {
      var delta;
      ctx = this;
      args = arguments;
      delta = new Date() - last;
      if (!timeoutID) {
        if (delta >= wait) {
          call();
        } else {
          timeoutID = setTimeout(call, wait - delta);
        }
      }
      return rtn;
    };
    throttled.clear = function() {
      if (!timeoutID) {
        return;
      }
      clearTimeout(timeoutID);
      return call();
    };
    return throttled;
  };

  Util.prototype.formatHTML = function(html) {
    var cursor, indentString, lastMatch, level, match, re, repeatString, result, str;
    re = /<(\/?)(.+?)(\/?)>/g;
    result = '';
    level = 0;
    lastMatch = null;
    indentString = '  ';
    repeatString = function(str, n) {
      return new Array(n + 1).join(str);
    };
    while ((match = re.exec(html)) !== null) {
      match.isBlockNode = $.inArray(match[2], this.blockNodes) > -1;
      match.isStartTag = match[1] !== '/' && match[3] !== '/';
      match.isEndTag = match[1] === '/' || match[3] === '/';
      cursor = lastMatch ? lastMatch.index + lastMatch[0].length : 0;
      if ((str = html.substring(cursor, match.index)).length > 0 && $.trim(str)) {
        result += str;
      }
      if (match.isBlockNode && match.isEndTag && !match.isStartTag) {
        level -= 1;
      }
      if (match.isBlockNode && match.isStartTag) {
        if (!(lastMatch && lastMatch.isBlockNode && lastMatch.isEndTag)) {
          result += '\n';
        }
        result += repeatString(indentString, level);
      }
      result += match[0];
      if (match.isBlockNode && match.isEndTag) {
        result += '\n';
      }
      if (match.isBlockNode && match.isStartTag) {
        level += 1;
      }
      lastMatch = match;
    }
    return $.trim(result);
  };

  return Util;

})(SimpleModule);

Toolbar = (function(superClass) {
  extend(Toolbar, superClass);

  function Toolbar() {
    return Toolbar.__super__.constructor.apply(this, arguments);
  }

  Toolbar.pluginName = 'Toolbar';

  Toolbar.prototype.opts = {
    toolbar: true,
    toolbarFloat: true,
    toolbarHidden: false,
    toolbarFloatOffset: 0
  };

  Toolbar.prototype._tpl = {
    wrapper: '<div class="simditor-toolbar"><ul></ul></div>',
    separator: '<li><span class="separator"></span></li>'
  };

  Toolbar.prototype._init = function() {
    var floatInitialized, initToolbarFloat, toolbarHeight;
    this.editor = this._module;
    if (!this.opts.toolbar) {
      return;
    }
    if (!$.isArray(this.opts.toolbar)) {
      this.opts.toolbar = ['bold', 'italic', 'underline', 'strikethrough', '|', 'ol', 'ul', 'blockquote', 'code', '|', 'link', 'image', '|', 'indent', 'outdent'];
    }
    this._render();
    this.list.on('click', function(e) {
      return false;
    });
    this.wrapper.on('mousedown', (function(_this) {
      return function(e) {
        return _this.list.find('.menu-on').removeClass('.menu-on');
      };
    })(this));
    $(document).on('mousedown.simditor' + this.editor.id, (function(_this) {
      return function(e) {
        return _this.list.find('.menu-on').removeClass('.menu-on');
      };
    })(this));
    if (!this.opts.toolbarHidden && this.opts.toolbarFloat) {
      this.wrapper.css('top', this.opts.toolbarFloatOffset);
      toolbarHeight = 0;
      initToolbarFloat = (function(_this) {
        return function() {
          _this.wrapper.css('position', 'static');
          _this.wrapper.width('auto');
          _this.editor.util.reflow(_this.wrapper);
          _this.wrapper.width(_this.wrapper.outerWidth());
          _this.wrapper.css('left', _this.editor.util.os.mobile ? _this.wrapper.position().left : _this.wrapper.offset().left);
          _this.wrapper.css('position', '');
          toolbarHeight = _this.wrapper.outerHeight();
          _this.editor.placeholderEl.css('top', toolbarHeight);
          return true;
        };
      })(this);
      floatInitialized = null;
      $(window).on('resize.simditor-' + this.editor.id, function(e) {
        return floatInitialized = initToolbarFloat();
      });
      $(window).on('scroll.simditor-' + this.editor.id, (function(_this) {
        return function(e) {
          var bottomEdge, scrollTop, topEdge;
          if (!_this.wrapper.is(':visible')) {
            return;
          }
          topEdge = _this.editor.wrapper.offset().top;
          bottomEdge = topEdge + _this.editor.wrapper.outerHeight() - 80;
          scrollTop = $(document).scrollTop() + _this.opts.toolbarFloatOffset;
          if (scrollTop <= topEdge || scrollTop >= bottomEdge) {
            _this.editor.wrapper.removeClass('toolbar-floating').css('padding-top', '');
            if (_this.editor.util.os.mobile) {
              return _this.wrapper.css('top', _this.opts.toolbarFloatOffset);
            }
          } else {
            floatInitialized || (floatInitialized = initToolbarFloat());
            _this.editor.wrapper.addClass('toolbar-floating').css('padding-top', toolbarHeight);
            if (_this.editor.util.os.mobile) {
              return _this.wrapper.css('top', scrollTop - topEdge + _this.opts.toolbarFloatOffset);
            }
          }
        };
      })(this));
    }
    this.editor.on('destroy', (function(_this) {
      return function() {
        return _this.buttons.length = 0;
      };
    })(this));
    return $(document).on("mousedown.simditor-" + this.editor.id, (function(_this) {
      return function(e) {
        return _this.list.find('li.menu-on').removeClass('menu-on');
      };
    })(this));
  };

  Toolbar.prototype._render = function() {
    var k, len, name, ref;
    this.buttons = [];
    this.wrapper = $(this._tpl.wrapper).prependTo(this.editor.wrapper);
    this.list = this.wrapper.find('ul');
    ref = this.opts.toolbar;
    for (k = 0, len = ref.length; k < len; k++) {
      name = ref[k];
      if (name === '|') {
        $(this._tpl.separator).appendTo(this.list);
        continue;
      }
      if (!this.constructor.buttons[name]) {
        throw new Error("simditor: invalid toolbar button " + name);
        continue;
      }
      this.buttons.push(new this.constructor.buttons[name]({
        editor: this.editor
      }));
    }
    if (this.opts.toolbarHidden) {
      return this.wrapper.hide();
    }
  };

  Toolbar.prototype.findButton = function(name) {
    var button;
    button = this.list.find('.toolbar-item-' + name).data('button');
    return button != null ? button : null;
  };

  Toolbar.addButton = function(btn) {
    return this.buttons[btn.prototype.name] = btn;
  };

  Toolbar.buttons = {};

  return Toolbar;

})(SimpleModule);

Indentation = (function(superClass) {
  extend(Indentation, superClass);

  function Indentation() {
    return Indentation.__super__.constructor.apply(this, arguments);
  }

  Indentation.pluginName = 'Indentation';

  Indentation.prototype.opts = {
    tabIndent: true
  };

  Indentation.prototype._init = function() {
    this.editor = this._module;
    return this.editor.keystroke.add('tab', '*', (function(_this) {
      return function(e) {
        var codeButton;
        codeButton = _this.editor.toolbar.findButton('code');
        if (!(_this.opts.tabIndent || (codeButton && codeButton.active))) {
          return;
        }
        return _this.indent(e.shiftKey);
      };
    })(this));
  };

  Indentation.prototype.indent = function(isBackward) {
    var $blockNodes, $endNodes, $startNodes, nodes, result;
    $startNodes = this.editor.selection.startNodes();
    $endNodes = this.editor.selection.endNodes();
    $blockNodes = this.editor.selection.blockNodes();
    nodes = [];
    $blockNodes = $blockNodes.each(function(i, node) {
      var include, j, k, len, n;
      include = true;
      for (j = k = 0, len = nodes.length; k < len; j = ++k) {
        n = nodes[j];
        if ($.contains(node, n)) {
          include = false;
          break;
        } else if ($.contains(n, node)) {
          nodes.splice(j, 1, node);
          include = false;
          break;
        }
      }
      if (include) {
        return nodes.push(node);
      }
    });
    $blockNodes = $(nodes);
    result = false;
    $blockNodes.each((function(_this) {
      return function(i, blockEl) {
        var r;
        r = isBackward ? _this.outdentBlock(blockEl) : _this.indentBlock(blockEl);
        if (r) {
          return result = r;
        }
      };
    })(this));
    return result;
  };

  Indentation.prototype.indentBlock = function(blockEl) {
    var $blockEl, $childList, $nextTd, $nextTr, $parentLi, $pre, $td, $tr, marginLeft, tagName;
    $blockEl = $(blockEl);
    if (!$blockEl.length) {
      return;
    }
    if ($blockEl.is('pre')) {
      $pre = this.editor.selection.containerNode();
      if (!($pre.is($blockEl) || $pre.closest('pre').is($blockEl))) {
        return;
      }
      this.indentText(this.editor.selection.range());
    } else if ($blockEl.is('li')) {
      $parentLi = $blockEl.prev('li');
      if ($parentLi.length < 1) {
        return;
      }
      this.editor.selection.save();
      tagName = $blockEl.parent()[0].tagName;
      $childList = $parentLi.children('ul, ol');
      if ($childList.length > 0) {
        $childList.append($blockEl);
      } else {
        $('<' + tagName + '/>').append($blockEl).appendTo($parentLi);
      }
      this.editor.selection.restore();
    } else if ($blockEl.is('p, h1, h2, h3, h4')) {
      marginLeft = parseInt($blockEl.css('margin-left')) || 0;
      marginLeft = (Math.round(marginLeft / this.opts.indentWidth) + 1) * this.opts.indentWidth;
      $blockEl.css('margin-left', marginLeft);
    } else if ($blockEl.is('table') || $blockEl.is('.simditor-table')) {
      $td = this.editor.selection.containerNode().closest('td, th');
      $nextTd = $td.next('td, th');
      if (!($nextTd.length > 0)) {
        $tr = $td.parent('tr');
        $nextTr = $tr.next('tr');
        if ($nextTr.length < 1 && $tr.parent().is('thead')) {
          $nextTr = $tr.parent('thead').next('tbody').find('tr:first');
        }
        $nextTd = $nextTr.find('td:first, th:first');
      }
      if (!($td.length > 0 && $nextTd.length > 0)) {
        return;
      }
      this.editor.selection.setRangeAtEndOf($nextTd);
    } else {
      return false;
    }
    return true;
  };

  Indentation.prototype.indentText = function(range) {
    var text, textNode;
    text = range.toString().replace(/^(?=.+)/mg, '\u00A0\u00A0');
    textNode = document.createTextNode(text || '\u00A0\u00A0');
    range.deleteContents();
    range.insertNode(textNode);
    if (text) {
      range.selectNode(textNode);
      return this.editor.selection.range(range);
    } else {
      return this.editor.selection.setRangeAfter(textNode);
    }
  };

  Indentation.prototype.outdentBlock = function(blockEl) {
    var $blockEl, $parent, $parentLi, $pre, $prevTd, $prevTr, $td, $tr, marginLeft, range;
    $blockEl = $(blockEl);
    if (!($blockEl && $blockEl.length > 0)) {
      return;
    }
    if ($blockEl.is('pre')) {
      $pre = this.editor.selection.containerNode();
      if (!($pre.is($blockEl) || $pre.closest('pre').is($blockEl))) {
        return;
      }
      this.outdentText(range);
    } else if ($blockEl.is('li')) {
      $parent = $blockEl.parent();
      $parentLi = $parent.parent('li');
      this.editor.selection.save();
      if ($parentLi.length < 1) {
        range = document.createRange();
        range.setStartBefore($parent[0]);
        range.setEndBefore($blockEl[0]);
        $parent.before(range.extractContents());
        $('<p/>').insertBefore($parent).after($blockEl.children('ul, ol')).append($blockEl.contents());
        $blockEl.remove();
      } else {
        if ($blockEl.next('li').length > 0) {
          $('<' + $parent[0].tagName + '/>').append($blockEl.nextAll('li')).appendTo($blockEl);
        }
        $blockEl.insertAfter($parentLi);
        if ($parent.children('li').length < 1) {
          $parent.remove();
        }
      }
      this.editor.selection.restore();
    } else if ($blockEl.is('p, h1, h2, h3, h4')) {
      marginLeft = parseInt($blockEl.css('margin-left')) || 0;
      marginLeft = Math.max(Math.round(marginLeft / this.opts.indentWidth) - 1, 0) * this.opts.indentWidth;
      $blockEl.css('margin-left', marginLeft === 0 ? '' : marginLeft);
    } else if ($blockEl.is('table') || $blockEl.is('.simditor-table')) {
      $td = this.editor.selection.containerNode().closest('td, th');
      $prevTd = $td.prev('td, th');
      if (!($prevTd.length > 0)) {
        $tr = $td.parent('tr');
        $prevTr = $tr.prev('tr');
        if ($prevTr.length < 1 && $tr.parent().is('tbody')) {
          $prevTr = $tr.parent('tbody').prev('thead').find('tr:first');
        }
        $prevTd = $prevTr.find('td:last, th:last');
      }
      if (!($td.length > 0 && $prevTd.length > 0)) {
        return;
      }
      this.editor.selection.setRangeAtEndOf($prevTd);
    } else {
      return false;
    }
    return true;
  };

  Indentation.prototype.outdentText = function(range) {};

  return Indentation;

})(SimpleModule);

Clipboard = (function(superClass) {
  extend(Clipboard, superClass);

  function Clipboard() {
    return Clipboard.__super__.constructor.apply(this, arguments);
  }

  Clipboard.pluginName = 'Clipboard';

  Clipboard.prototype.opts = {
    pasteImage: false,
    cleanPaste: false
  };

  Clipboard.prototype._init = function() {
    this.editor = this._module;
    if (this.opts.pasteImage && typeof this.opts.pasteImage !== 'string') {
      this.opts.pasteImage = 'inline';
    }
    return this.editor.body.on('paste', (function(_this) {
      return function(e) {
        var range;
        if (_this.pasting || _this._pasteBin) {
          return;
        }
        if (_this.editor.triggerHandler(e) === false) {
          return false;
        }
        range = _this.editor.selection.deleteRangeContents();
        if (_this.editor.body.html()) {
          if (!range.collapsed) {
            range.collapse(true);
          }
        } else {
          _this.editor.formatter.format();
          _this.editor.selection.setRangeAtStartOf(_this.editor.body.find('p:first'));
        }
        if (_this._processPasteByClipboardApi(e)) {
          return false;
        }
        _this.editor.inputManager.throttledValueChanged.clear();
        _this.editor.inputManager.throttledSelectionChanged.clear();
        _this.editor.undoManager.throttledPushState.clear();
        _this.editor.selection.reset();
        _this.editor.undoManager.resetCaretPosition();
        _this.pasting = true;
        return _this._getPasteContent(function(pasteContent) {
          _this._processPasteContent(pasteContent);
          _this._pasteInBlockEl = null;
          _this._pastePlainText = null;
          return _this.pasting = false;
        });
      };
    })(this));
  };

  Clipboard.prototype._processPasteByClipboardApi = function(e) {
    var imageFile, pasteItem, ref, uploadOpt;
    if (this.editor.util.browser.edge) {
      return;
    }
    if (e.originalEvent.clipboardData && e.originalEvent.clipboardData.items && e.originalEvent.clipboardData.items.length > 0) {
      pasteItem = e.originalEvent.clipboardData.items[0];
      if (/^image\//.test(pasteItem.type)) {
        imageFile = pasteItem.getAsFile();
        if (!((imageFile != null) && this.opts.pasteImage)) {
          return;
        }
        if (!imageFile.name) {
          imageFile.name = "Clipboard Image.png";
        }
        if (this.editor.triggerHandler('pasting', [imageFile]) === false) {
          return;
        }
        uploadOpt = {};
        uploadOpt[this.opts.pasteImage] = true;
        if ((ref = this.editor.uploader) != null) {
          ref.upload(imageFile, uploadOpt);
        }
        return true;
      }
    }
  };

  Clipboard.prototype._getPasteContent = function(callback) {
    var state;
    this._pasteBin = $('<div contenteditable="true" />').addClass('simditor-paste-bin').attr('tabIndex', '-1').appendTo(this.editor.el);
    state = {
      html: this.editor.body.html(),
      caret: this.editor.undoManager.caretPosition()
    };
    this._pasteBin.focus();
    return setTimeout((function(_this) {
      return function() {
        var pasteContent;
        _this.editor.hidePopover();
        _this.editor.body.get(0).innerHTML = state.html;
        _this.editor.undoManager.caretPosition(state.caret);
        _this.editor.body.focus();
        _this.editor.selection.reset();
        _this.editor.selection.range();
        _this._pasteInBlockEl = _this.editor.selection.blockNodes().last();
        _this._pastePlainText = _this.opts.cleanPaste || _this._pasteInBlockEl.is('pre, table');
        if (_this._pastePlainText) {
          pasteContent = _this.editor.formatter.clearHtml(_this._pasteBin.html(), true);
        } else {
          pasteContent = $('<div/>').append(_this._pasteBin.contents());
          pasteContent.find('style').remove();
          pasteContent.find('table colgroup').remove();
          _this._cleanPasteFontSize(pasteContent);
          _this.editor.formatter.format(pasteContent);
          _this.editor.formatter.decorate(pasteContent);
          _this.editor.formatter.beautify(pasteContent.children());
          pasteContent = pasteContent.contents();
        }
        _this._pasteBin.remove();
        _this._pasteBin = null;
        return callback(pasteContent);
      };
    })(this), 0);
  };

  Clipboard.prototype._processPasteContent = function(pasteContent) {
    var $blockEl, $img, blob, children, dataURLtoBlob, img, insertPosition, k, l, lastLine, len, len1, len2, len3, len4, line, lines, m, node, o, q, ref, ref1, ref2, uploadOpt, uploader;
    if (this.editor.triggerHandler('pasting', [pasteContent]) === false) {
      return;
    }
    $blockEl = this._pasteInBlockEl;
    if (!pasteContent) {
      return;
    }
    if (this._pastePlainText) {
      if ($blockEl.is('table')) {
        lines = pasteContent.split('\n');
        lastLine = lines.pop();
        for (k = 0, len = lines.length; k < len; k++) {
          line = lines[k];
          this.editor.selection.insertNode(document.createTextNode(line));
          this.editor.selection.insertNode($('<br/>'));
        }
        this.editor.selection.insertNode(document.createTextNode(lastLine));
      } else {
        pasteContent = $('<div/>').text(pasteContent);
        ref = pasteContent.contents();
        for (l = 0, len1 = ref.length; l < len1; l++) {
          node = ref[l];
          this.editor.selection.insertNode($(node)[0]);
        }
      }
    } else if ($blockEl.is(this.editor.body)) {
      for (m = 0, len2 = pasteContent.length; m < len2; m++) {
        node = pasteContent[m];
        this.editor.selection.insertNode(node);
      }
    } else if (pasteContent.length < 1) {
      return;
    } else if (pasteContent.length === 1) {
      if (pasteContent.is('p')) {
        children = pasteContent.contents();
        if ($blockEl.is('h1, h2, h3, h4, h5')) {
          if (children.length) {
            children.css('font-size', '');
          }
        }
        if (children.length === 1 && children.is('img')) {
          $img = children;
          if (/^data:image/.test($img.attr('src'))) {
            if (!this.opts.pasteImage) {
              return;
            }
            blob = this.editor.util.dataURLtoBlob($img.attr("src"));
            blob.name = "Clipboard Image.png";
            uploadOpt = {};
            uploadOpt[this.opts.pasteImage] = true;
            if ((ref1 = this.editor.uploader) != null) {
              ref1.upload(blob, uploadOpt);
            }
            return;
          } else if (new RegExp('^blob:' + location.origin + '/').test($img.attr('src'))) {
            if (!this.opts.pasteImage) {
              return;
            }
            uploadOpt = {};
            uploadOpt[this.opts.pasteImage] = true;
            dataURLtoBlob = this.editor.util.dataURLtoBlob;
            uploader = this.editor.uploader;
            img = new Image;
            img.onload = function() {
              var canvas;
              canvas = document.createElement('canvas');
              canvas.width = img.naturalWidth;
              canvas.height = img.naturalHeight;
              canvas.getContext('2d').drawImage(img, 0, 0);
              blob = dataURLtoBlob(canvas.toDataURL('image/png'));
              blob.name = 'Clipboard Image.png';
              if (uploader !== null) {
                uploader.upload(blob, uploadOpt);
              }
            };
            img.src = $img.attr('src');
            return;
          } else if ($img.is('img[src^="webkit-fake-url://"]')) {
            return;
          }
        }
        for (o = 0, len3 = children.length; o < len3; o++) {
          node = children[o];
          this.editor.selection.insertNode(node);
        }
      } else if ($blockEl.is('p') && this.editor.util.isEmptyNode($blockEl)) {
        $blockEl.replaceWith(pasteContent);
        this.editor.selection.setRangeAtEndOf(pasteContent);
      } else if (pasteContent.is('ul, ol')) {
        if (pasteContent.find('li').length === 1) {
          pasteContent = $('<div/>').text(pasteContent.text());
          ref2 = pasteContent.contents();
          for (q = 0, len4 = ref2.length; q < len4; q++) {
            node = ref2[q];
            this.editor.selection.insertNode($(node)[0]);
          }
        } else if ($blockEl.is('li')) {
          $blockEl.parent().after(pasteContent);
          this.editor.selection.setRangeAtEndOf(pasteContent);
        } else {
          $blockEl.after(pasteContent);
          this.editor.selection.setRangeAtEndOf(pasteContent);
        }
      } else {
        $blockEl.after(pasteContent);
        this.editor.selection.setRangeAtEndOf(pasteContent);
      }
    } else {
      if ($blockEl.is('li')) {
        $blockEl = $blockEl.parent();
      }
      if (this.editor.selection.rangeAtStartOf($blockEl)) {
        insertPosition = 'before';
      } else if (this.editor.selection.rangeAtEndOf($blockEl)) {
        insertPosition = 'after';
      } else {
        this.editor.selection.breakBlockEl($blockEl);
        insertPosition = 'before';
      }
      $blockEl[insertPosition](pasteContent);
      this.editor.selection.setRangeAtEndOf(pasteContent.last());
    }
    return this.editor.inputManager.throttledValueChanged();
  };

  Clipboard.prototype._cleanPasteFontSize = function(node) {
    var $node, sizeMap;
    $node = $(node);
    if (!($node.length > 0)) {
      return;
    }
    sizeMap = ['1.5em', '1.25em', '0.75em', '0.5em'];
    return $node.find('[style*="font-size"]').map(function(i, el) {
      var $el;
      $el = $(el);
      if ($.inArray($el.css('font-size'), sizeMap) < 0) {
        return $el.css('font-size', '');
      }
    });
  };

  return Clipboard;

})(SimpleModule);

Simditor = (function(superClass) {
  extend(Simditor, superClass);

  function Simditor() {
    return Simditor.__super__.constructor.apply(this, arguments);
  }

  Simditor.connect(Util);

  Simditor.connect(InputManager);

  Simditor.connect(Selection);

  Simditor.connect(UndoManager);

  Simditor.connect(Keystroke);

  Simditor.connect(Formatter);

  Simditor.connect(Toolbar);

  Simditor.connect(Indentation);

  Simditor.connect(Clipboard);

  Simditor.count = 0;

  Simditor.prototype.opts = {
    textarea: null,
    placeholder: '',
    defaultImage: 'images/image.png',
    params: {},
    upload: false,
    indentWidth: 40
  };

  Simditor.prototype._init = function() {
    var e, editor, uploadOpts;
    this.textarea = $(this.opts.textarea);
    this.opts.placeholder = this.opts.placeholder || this.textarea.attr('placeholder');
    if (!this.textarea.length) {
      throw new Error('simditor: param textarea is required.');
      return;
    }
    editor = this.textarea.data('simditor');
    if (editor != null) {
      editor.destroy();
    }
    this.id = ++Simditor.count;
    this._render();
    if (simpleHotkeys) {
      this.hotkeys = simpleHotkeys({
        el: this.body
      });
    } else {
      throw new Error('simditor: simple-hotkeys is required.');
      return;
    }
    if (this.opts.upload && simpleUploader) {
      uploadOpts = typeof this.opts.upload === 'object' ? this.opts.upload : {};
      this.uploader = simpleUploader(uploadOpts);
    }
    this.on('initialized', (function(_this) {
      return function() {
        if (_this.opts.placeholder) {
          _this.on('valuechanged', function() {
            return _this._placeholder();
          });
        }
        _this.setValue(_this.textarea.val().trim() || '');
        if (_this.textarea.attr('autofocus')) {
          return _this.focus();
        }
      };
    })(this));
    if (this.util.browser.mozilla) {
      this.util.reflow();
      try {
        document.execCommand('enableObjectResizing', false, false);
        return document.execCommand('enableInlineTableEditing', false, false);
      } catch (_error) {
        e = _error;
      }
    }
  };

  Simditor.prototype._tpl = "<div class=\"simditor\">\n  <div class=\"simditor-wrapper\">\n    <div class=\"simditor-placeholder\"></div>\n    <div class=\"simditor-body\" contenteditable=\"true\">\n    </div>\n  </div>\n</div>";

  Simditor.prototype._render = function() {
    var key, ref, results, val;
    this.el = $(this._tpl).insertBefore(this.textarea);
    this.wrapper = this.el.find('.simditor-wrapper');
    this.body = this.wrapper.find('.simditor-body');
    this.placeholderEl = this.wrapper.find('.simditor-placeholder').append(this.opts.placeholder);
    this.el.data('simditor', this);
    this.wrapper.append(this.textarea);
    this.textarea.data('simditor', this).blur();
    this.body.attr('tabindex', this.textarea.attr('tabindex'));
    if (this.util.os.mac) {
      this.el.addClass('simditor-mac');
    } else if (this.util.os.linux) {
      this.el.addClass('simditor-linux');
    }
    if (this.util.os.mobile) {
      this.el.addClass('simditor-mobile');
    }
    if (this.opts.params) {
      ref = this.opts.params;
      results = [];
      for (key in ref) {
        val = ref[key];
        results.push($('<input/>', {
          type: 'hidden',
          name: key,
          value: val
        }).insertAfter(this.textarea));
      }
      return results;
    }
  };

  Simditor.prototype._placeholder = function() {
    var children;
    children = this.body.children();
    if (children.length === 0 || (children.length === 1 && this.util.isEmptyNode(children) && parseInt(children.css('margin-left') || 0) < this.opts.indentWidth)) {
      return this.placeholderEl.show();
    } else {
      return this.placeholderEl.hide();
    }
  };

  Simditor.prototype.setValue = function(val) {
    this.hidePopover();
    this.textarea.val(val);
    this.body.get(0).innerHTML = val;
    this.formatter.format();
    this.formatter.decorate();
    this.util.reflow(this.body);
    this.inputManager.lastCaretPosition = null;
    return this.trigger('valuechanged');
  };

  Simditor.prototype.getValue = function() {
    return this.sync();
  };

  Simditor.prototype.sync = function() {
    var children, cloneBody, emptyP, firstP, lastP, val;
    cloneBody = this.body.clone();
    this.formatter.undecorate(cloneBody);
    this.formatter.format(cloneBody);
    this.formatter.autolink(cloneBody);
    children = cloneBody.children();
    lastP = children.last('p');
    firstP = children.first('p');
    while (lastP.is('p') && this.util.isEmptyNode(lastP)) {
      emptyP = lastP;
      lastP = lastP.prev('p');
      emptyP.remove();
    }
    while (firstP.is('p') && this.util.isEmptyNode(firstP)) {
      emptyP = firstP;
      firstP = lastP.next('p');
      emptyP.remove();
    }
    cloneBody.find('img.uploading').remove();
    val = $.trim(cloneBody.html());
    this.textarea.val(val);
    return val;
  };

  Simditor.prototype.focus = function() {
    var $blockEl, range;
    if (!(this.body.is(':visible') && this.body.is('[contenteditable]'))) {
      this.el.find('textarea:visible').focus();
      return;
    }
    if (this.inputManager.lastCaretPosition) {
      this.undoManager.caretPosition(this.inputManager.lastCaretPosition);
      return this.inputManager.lastCaretPosition = null;
    } else {
      $blockEl = this.body.children().last();
      if (!$blockEl.is('p')) {
        $blockEl = $('<p/>').append(this.util.phBr).appendTo(this.body);
      }
      range = document.createRange();
      return this.selection.setRangeAtEndOf($blockEl, range);
    }
  };

  Simditor.prototype.blur = function() {
    if (this.body.is(':visible') && this.body.is('[contenteditable]')) {
      return this.body.blur();
    } else {
      return this.body.find('textarea:visible').blur();
    }
  };

  Simditor.prototype.hidePopover = function() {
    return this.el.find('.simditor-popover').each(function(i, popover) {
      popover = $(popover).data('popover');
      if (popover.active) {
        return popover.hide();
      }
    });
  };

  Simditor.prototype.destroy = function() {
    this.triggerHandler('destroy');
    this.textarea.closest('form').off('.simditor .simditor-' + this.id);
    this.selection.clear();
    this.inputManager.focused = false;
    this.textarea.insertBefore(this.el).hide().val('').removeData('simditor');
    this.el.remove();
    $(document).off('.simditor-' + this.id);
    $(window).off('.simditor-' + this.id);
    return this.off();
  };

  return Simditor;

})(SimpleModule);

Simditor.i18n = {
  'zh-CN': {
    'blockquote': '引用',
    'bold': '加粗文字',
    'code': '插入代码',
    'color': '文字颜色',
    'coloredText': '彩色文字',
    'hr': '分隔线',
    'image': '插入图片',
    'externalImage': '外链图片',
    'uploadImage': '上传图片',
    'uploadFailed': '上传失败了',
    'uploadError': '上传出错了',
    'imageUrl': '图片地址',
    'imageSize': '图片尺寸',
    'imageAlt': '图片描述',
    'restoreImageSize': '还原图片尺寸',
    'uploading': '正在上传',
    'indent': '向右缩进',
    'outdent': '向左缩进',
    'italic': '斜体文字',
    'link': '插入链接',
    'linkText': '链接文字',
    'linkUrl': '链接地址',
    'linkTarget': '打开方式',
    'openLinkInCurrentWindow': '在当前窗口中打开',
    'openLinkInNewWindow': '在新窗口中打开',
    'removeLink': '移除链接',
    'ol': '有序列表',
    'ul': '无序列表',
    'strikethrough': '删除线文字',
    'table': '表格',
    'deleteRow': '删除行',
    'insertRowAbove': '在上面插入行',
    'insertRowBelow': '在下面插入行',
    'deleteColumn': '删除列',
    'insertColumnLeft': '在左边插入列',
    'insertColumnRight': '在右边插入列',
    'deleteTable': '删除表格',
    'title': '标题',
    'normalText': '普通文本',
    'underline': '下划线文字',
    'alignment': '水平对齐',
    'alignCenter': '居中',
    'alignLeft': '居左',
    'alignRight': '居右',
    'selectLanguage': '选择程序语言',
    'fontScale': '字体大小',
    'fontScaleXLarge': '超大字体',
    'fontScaleLarge': '大号字体',
    'fontScaleNormal': '正常大小',
    'fontScaleSmall': '小号字体',
    'fontScaleXSmall': '超小字体'
  },
  'en-US': {
    'blockquote': 'Block Quote',
    'bold': 'Bold',
    'code': 'Code',
    'color': 'Text Color',
    'coloredText': 'Colored Text',
    'hr': 'Horizontal Line',
    'image': 'Insert Image',
    'externalImage': 'External Image',
    'uploadImage': 'Upload Image',
    'uploadFailed': 'Upload failed',
    'uploadError': 'Error occurs during upload',
    'imageUrl': 'Url',
    'imageSize': 'Size',
    'imageAlt': 'Alt',
    'restoreImageSize': 'Restore Origin Size',
    'uploading': 'Uploading',
    'indent': 'Indent',
    'outdent': 'Outdent',
    'italic': 'Italic',
    'link': 'Insert Link',
    'linkText': 'Text',
    'linkUrl': 'Url',
    'linkTarget': 'Target',
    'openLinkInCurrentWindow': 'Open link in current window',
    'openLinkInNewWindow': 'Open link in new window',
    'removeLink': 'Remove Link',
    'ol': 'Ordered List',
    'ul': 'Unordered List',
    'strikethrough': 'Strikethrough',
    'table': 'Table',
    'deleteRow': 'Delete Row',
    'insertRowAbove': 'Insert Row Above',
    'insertRowBelow': 'Insert Row Below',
    'deleteColumn': 'Delete Column',
    'insertColumnLeft': 'Insert Column Left',
    'insertColumnRight': 'Insert Column Right',
    'deleteTable': 'Delete Table',
    'title': 'Title',
    'normalText': 'Text',
    'underline': 'Underline',
    'alignment': 'Alignment',
    'alignCenter': 'Align Center',
    'alignLeft': 'Align Left',
    'alignRight': 'Align Right',
    'selectLanguage': 'Select Language',
    'fontScale': 'Font Size',
    'fontScaleXLarge': 'X Large Size',
    'fontScaleLarge': 'Large Size',
    'fontScaleNormal': 'Normal Size',
    'fontScaleSmall': 'Small Size',
    'fontScaleXSmall': 'X Small Size'
  }
};

Button = (function(superClass) {
  extend(Button, superClass);

  Button.prototype._tpl = {
    item: '<li><a tabindex="-1" unselectable="on" class="toolbar-item" href="javascript:;"><span></span></a></li>',
    menuWrapper: '<div class="toolbar-menu"></div>',
    menuItem: '<li><a tabindex="-1" unselectable="on" class="menu-item" href="javascript:;"><span></span></a></li>',
    separator: '<li><span class="separator"></span></li>'
  };

  Button.prototype.name = '';

  Button.prototype.icon = '';

  Button.prototype.title = '';

  Button.prototype.text = '';

  Button.prototype.htmlTag = '';

  Button.prototype.disableTag = '';

  Button.prototype.menu = false;

  Button.prototype.active = false;

  Button.prototype.disabled = false;

  Button.prototype.needFocus = true;

  Button.prototype.shortcut = null;

  function Button(opts) {
    this.editor = opts.editor;
    this.title = this._t(this.name);
    Button.__super__.constructor.call(this, opts);
  }

  Button.prototype._init = function() {
    var k, len, ref, tag;
    this.render();
    this.el.on('mousedown', (function(_this) {
      return function(e) {
        var exceed, noFocus, param;
        e.preventDefault();
        noFocus = _this.needFocus && !_this.editor.inputManager.focused;
        if (_this.el.hasClass('disabled')) {
          return false;
        }
        if (noFocus) {
          _this.editor.focus();
        }
        if (_this.menu) {
          _this.wrapper.toggleClass('menu-on').siblings('li').removeClass('menu-on');
          if (_this.wrapper.is('.menu-on')) {
            exceed = _this.menuWrapper.offset().left + _this.menuWrapper.outerWidth() + 5 - _this.editor.wrapper.offset().left - _this.editor.wrapper.outerWidth();
            if (exceed > 0) {
              _this.menuWrapper.css({
                'left': 'auto',
                'right': 0
              });
            }
            _this.trigger('menuexpand');
          }
          return false;
        }
        param = _this.el.data('param');
        _this.command(param);
        return false;
      };
    })(this));
    this.wrapper.on('click', 'a.menu-item', (function(_this) {
      return function(e) {
        var btn, noFocus, param;
        e.preventDefault();
        btn = $(e.currentTarget);
        _this.wrapper.removeClass('menu-on');
        noFocus = _this.needFocus && !_this.editor.inputManager.focused;
        if (btn.hasClass('disabled') || noFocus) {
          return false;
        }
        _this.editor.toolbar.wrapper.removeClass('menu-on');
        param = btn.data('param');
        _this.command(param);
        return false;
      };
    })(this));
    this.wrapper.on('mousedown', 'a.menu-item', function(e) {
      return false;
    });
    this.editor.on('blur', (function(_this) {
      return function() {
        var editorActive;
        editorActive = _this.editor.body.is(':visible') && _this.editor.body.is('[contenteditable]');
        if (!(editorActive && !_this.editor.clipboard.pasting)) {
          return;
        }
        _this.setActive(false);
        return _this.setDisabled(false);
      };
    })(this));
    if (this.shortcut != null) {
      this.editor.hotkeys.add(this.shortcut, (function(_this) {
        return function(e) {
          _this.el.mousedown();
          return false;
        };
      })(this));
    }
    ref = this.htmlTag.split(',');
    for (k = 0, len = ref.length; k < len; k++) {
      tag = ref[k];
      tag = $.trim(tag);
      if (tag && $.inArray(tag, this.editor.formatter._allowedTags) < 0) {
        this.editor.formatter._allowedTags.push(tag);
      }
    }
    return this.editor.on('selectionchanged', (function(_this) {
      return function(e) {
        if (_this.editor.inputManager.focused) {
          return _this._status();
        }
      };
    })(this));
  };

  Button.prototype.iconClassOf = function(icon) {
    if (icon) {
      return "simditor-icon simditor-icon-" + icon;
    } else {
      return '';
    }
  };

  Button.prototype.setIcon = function(icon) {
    return this.el.find('span').removeClass().addClass(this.iconClassOf(icon)).text(this.text);
  };

  Button.prototype.render = function() {
    this.wrapper = $(this._tpl.item).appendTo(this.editor.toolbar.list);
    this.el = this.wrapper.find('a.toolbar-item');
    this.el.attr('title', this.title).addClass("toolbar-item-" + this.name).data('button', this);
    this.setIcon(this.icon);
    if (!this.menu) {
      return;
    }
    this.menuWrapper = $(this._tpl.menuWrapper).appendTo(this.wrapper);
    this.menuWrapper.addClass("toolbar-menu-" + this.name);
    return this.renderMenu();
  };

  Button.prototype.renderMenu = function() {
    var $menuBtnEl, $menuItemEl, k, len, menuItem, ref, ref1, results;
    if (!$.isArray(this.menu)) {
      return;
    }
    this.menuEl = $('<ul/>').appendTo(this.menuWrapper);
    ref = this.menu;
    results = [];
    for (k = 0, len = ref.length; k < len; k++) {
      menuItem = ref[k];
      if (menuItem === '|') {
        $(this._tpl.separator).appendTo(this.menuEl);
        continue;
      }
      $menuItemEl = $(this._tpl.menuItem).appendTo(this.menuEl);
      $menuBtnEl = $menuItemEl.find('a.menu-item').attr({
        'title': (ref1 = menuItem.title) != null ? ref1 : menuItem.text,
        'data-param': menuItem.param
      }).addClass('menu-item-' + menuItem.name);
      if (menuItem.icon) {
        results.push($menuBtnEl.find('span').addClass(this.iconClassOf(menuItem.icon)));
      } else {
        results.push($menuBtnEl.find('span').text(menuItem.text));
      }
    }
    return results;
  };

  Button.prototype.setActive = function(active) {
    if (active === this.active) {
      return;
    }
    this.active = active;
    return this.el.toggleClass('active', this.active);
  };

  Button.prototype.setDisabled = function(disabled) {
    if (disabled === this.disabled) {
      return;
    }
    this.disabled = disabled;
    return this.el.toggleClass('disabled', this.disabled);
  };

  Button.prototype._disableStatus = function() {
    var disabled, endNodes, startNodes;
    startNodes = this.editor.selection.startNodes();
    endNodes = this.editor.selection.endNodes();
    disabled = startNodes.filter(this.disableTag).length > 0 || endNodes.filter(this.disableTag).length > 0;
    this.setDisabled(disabled);
    if (this.disabled) {
      this.setActive(false);
    }
    return this.disabled;
  };

  Button.prototype._activeStatus = function() {
    var active, endNode, endNodes, startNode, startNodes;
    startNodes = this.editor.selection.startNodes();
    endNodes = this.editor.selection.endNodes();
    startNode = startNodes.filter(this.htmlTag);
    endNode = endNodes.filter(this.htmlTag);
    active = startNode.length > 0 && endNode.length > 0 && startNode.is(endNode);
    this.node = active ? startNode : null;
    this.setActive(active);
    return this.active;
  };

  Button.prototype._status = function() {
    this._disableStatus();
    if (this.disabled) {
      return;
    }
    return this._activeStatus();
  };

  Button.prototype.command = function(param) {};

  Button.prototype._t = function() {
    var args, ref, result;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    result = Button.__super__._t.apply(this, args);
    if (!result) {
      result = (ref = this.editor)._t.apply(ref, args);
    }
    return result;
  };

  return Button;

})(SimpleModule);

Simditor.Button = Button;

Popover = (function(superClass) {
  extend(Popover, superClass);

  Popover.prototype.offset = {
    top: 4,
    left: 0
  };

  Popover.prototype.target = null;

  Popover.prototype.active = false;

  function Popover(opts) {
    this.button = opts.button;
    this.editor = opts.button.editor;
    Popover.__super__.constructor.call(this, opts);
  }

  Popover.prototype._init = function() {
    this.el = $('<div class="simditor-popover"></div>').appendTo(this.editor.el).data('popover', this);
    this.render();
    this.el.on('mouseenter', (function(_this) {
      return function(e) {
        return _this.el.addClass('hover');
      };
    })(this));
    return this.el.on('mouseleave', (function(_this) {
      return function(e) {
        return _this.el.removeClass('hover');
      };
    })(this));
  };

  Popover.prototype.render = function() {};

  Popover.prototype._initLabelWidth = function() {
    var $fields;
    $fields = this.el.find('.settings-field');
    if (!($fields.length > 0)) {
      return;
    }
    this._labelWidth = 0;
    $fields.each((function(_this) {
      return function(i, field) {
        var $field, $label;
        $field = $(field);
        $label = $field.find('label');
        if (!($label.length > 0)) {
          return;
        }
        return _this._labelWidth = Math.max(_this._labelWidth, $label.width());
      };
    })(this));
    return $fields.find('label').width(this._labelWidth);
  };

  Popover.prototype.show = function($target, position) {
    if (position == null) {
      position = 'bottom';
    }
    if ($target == null) {
      return;
    }
    this.el.siblings('.simditor-popover').each(function(i, popover) {
      popover = $(popover).data('popover');
      if (popover.active) {
        return popover.hide();
      }
    });
    if (this.active && this.target) {
      this.target.removeClass('selected');
    }
    this.target = $target.addClass('selected');
    if (this.active) {
      this.refresh(position);
      return this.trigger('popovershow');
    } else {
      this.active = true;
      this.el.css({
        left: -9999
      }).show();
      if (!this._labelWidth) {
        this._initLabelWidth();
      }
      this.editor.util.reflow();
      this.refresh(position);
      return this.trigger('popovershow');
    }
  };

  Popover.prototype.hide = function() {
    if (!this.active) {
      return;
    }
    if (this.target) {
      this.target.removeClass('selected');
    }
    this.target = null;
    this.active = false;
    this.el.hide();
    return this.trigger('popoverhide');
  };

  Popover.prototype.refresh = function(position) {
    var editorOffset, left, maxLeft, targetH, targetOffset, top;
    if (position == null) {
      position = 'bottom';
    }
    if (!this.active) {
      return;
    }
    editorOffset = this.editor.el.offset();
    targetOffset = this.target.offset();
    targetH = this.target.outerHeight();
    if (position === 'bottom') {
      top = targetOffset.top - editorOffset.top + targetH;
    } else if (position === 'top') {
      top = targetOffset.top - editorOffset.top - this.el.height();
    }
    maxLeft = this.editor.wrapper.width() - this.el.outerWidth() - 10;
    left = Math.min(targetOffset.left - editorOffset.left, maxLeft);
    return this.el.css({
      top: top + this.offset.top,
      left: left + this.offset.left
    });
  };

  Popover.prototype.destroy = function() {
    this.target = null;
    this.active = false;
    this.editor.off('.linkpopover');
    return this.el.remove();
  };

  Popover.prototype._t = function() {
    var args, ref, result;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    result = Popover.__super__._t.apply(this, args);
    if (!result) {
      result = (ref = this.button)._t.apply(ref, args);
    }
    return result;
  };

  return Popover;

})(SimpleModule);

Simditor.Popover = Popover;

TitleButton = (function(superClass) {
  extend(TitleButton, superClass);

  function TitleButton() {
    return TitleButton.__super__.constructor.apply(this, arguments);
  }

  TitleButton.prototype.name = 'title';

  TitleButton.prototype.htmlTag = 'h1, h2, h3, h4, h5';

  TitleButton.prototype.disableTag = 'pre, table';

  TitleButton.prototype._init = function() {
    this.menu = [
      {
        name: 'normal',
        text: this._t('normalText'),
        param: 'p'
      }, '|', {
        name: 'h1',
        text: this._t('title') + ' 1',
        param: 'h1'
      }, {
        name: 'h2',
        text: this._t('title') + ' 2',
        param: 'h2'
      }, {
        name: 'h3',
        text: this._t('title') + ' 3',
        param: 'h3'
      }, {
        name: 'h4',
        text: this._t('title') + ' 4',
        param: 'h4'
      }, {
        name: 'h5',
        text: this._t('title') + ' 5',
        param: 'h5'
      }
    ];
    return TitleButton.__super__._init.call(this);
  };

  TitleButton.prototype.setActive = function(active, param) {
    TitleButton.__super__.setActive.call(this, active);
    if (active) {
      param || (param = this.node[0].tagName.toLowerCase());
    }
    this.el.removeClass('active-p active-h1 active-h2 active-h3 active-h4 active-h5');
    if (active) {
      return this.el.addClass('active active-' + param);
    }
  };

  TitleButton.prototype.command = function(param) {
    var $rootNodes;
    $rootNodes = this.editor.selection.rootNodes();
    this.editor.selection.save();
    $rootNodes.each((function(_this) {
      return function(i, node) {
        var $node;
        $node = $(node);
        if ($node.is('blockquote') || $node.is(param) || $node.is(_this.disableTag) || _this.editor.util.isDecoratedNode($node)) {
          return;
        }
        return $('<' + param + '/>').append($node.contents()).replaceAll($node);
      };
    })(this));
    this.editor.selection.restore();
    return this.editor.trigger('valuechanged');
  };

  return TitleButton;

})(Button);

Simditor.Toolbar.addButton(TitleButton);

FontScaleButton = (function(superClass) {
  extend(FontScaleButton, superClass);

  function FontScaleButton() {
    return FontScaleButton.__super__.constructor.apply(this, arguments);
  }

  FontScaleButton.prototype.name = 'fontScale';

  FontScaleButton.prototype.icon = 'font';

  FontScaleButton.prototype.htmlTag = 'span';

  FontScaleButton.prototype.disableTag = 'pre, h1, h2, h3, h4, h5';

  FontScaleButton.prototype.sizeMap = {
    'x-large': '1.5em',
    'large': '1.25em',
    'small': '.75em',
    'x-small': '.5em'
  };

  FontScaleButton.prototype._init = function() {
    this.menu = [
      {
        name: '150%',
        text: this._t('fontScaleXLarge'),
        param: '5'
      }, {
        name: '125%',
        text: this._t('fontScaleLarge'),
        param: '4'
      }, {
        name: '100%',
        text: this._t('fontScaleNormal'),
        param: '3'
      }, {
        name: '75%',
        text: this._t('fontScaleSmall'),
        param: '2'
      }, {
        name: '50%',
        text: this._t('fontScaleXSmall'),
        param: '1'
      }
    ];
    return FontScaleButton.__super__._init.call(this);
  };

  FontScaleButton.prototype._activeStatus = function() {
    var active, endNode, endNodes, range, startNode, startNodes;
    range = this.editor.selection.range();
    startNodes = this.editor.selection.startNodes();
    endNodes = this.editor.selection.endNodes();
    startNode = startNodes.filter('span[style*="font-size"]');
    endNode = endNodes.filter('span[style*="font-size"]');
    active = startNodes.length > 0 && endNodes.length > 0 && startNode.is(endNode);
    this.setActive(active);
    return this.active;
  };

  FontScaleButton.prototype.command = function(param) {
    var $scales, containerNode, range;
    range = this.editor.selection.range();
    if (range.collapsed) {
      return;
    }
    this.editor.selection.range(range);
    document.execCommand('styleWithCSS', false, true);
    document.execCommand('fontSize', false, param);
    document.execCommand('styleWithCSS', false, false);
    this.editor.selection.reset();
    this.editor.selection.range();
    containerNode = this.editor.selection.containerNode();
    if (containerNode[0].nodeType === Node.TEXT_NODE) {
      $scales = containerNode.closest('span[style*="font-size"]');
    } else {
      $scales = containerNode.find('span[style*="font-size"]');
    }
    $scales.each((function(_this) {
      return function(i, n) {
        var $span, size;
        $span = $(n);
        size = n.style.fontSize;
        if (/large|x-large|small|x-small/.test(size)) {
          return $span.css('fontSize', _this.sizeMap[size]);
        } else if (size === 'medium') {
          if ($span[0].style.length > 1) {
            return $span.css('fontSize', '');
          } else {
            return $span.replaceWith($span.contents());
          }
        }
      };
    })(this));
    return this.editor.trigger('valuechanged');
  };

  return FontScaleButton;

})(Button);

Simditor.Toolbar.addButton(FontScaleButton);

BoldButton = (function(superClass) {
  extend(BoldButton, superClass);

  function BoldButton() {
    return BoldButton.__super__.constructor.apply(this, arguments);
  }

  BoldButton.prototype.name = 'bold';

  BoldButton.prototype.icon = 'bold';

  BoldButton.prototype.htmlTag = 'b, strong';

  BoldButton.prototype.disableTag = 'pre';

  BoldButton.prototype.shortcut = 'cmd+b';

  BoldButton.prototype._init = function() {
    if (this.editor.util.os.mac) {
      this.title = this.title + ' ( Cmd + b )';
    } else {
      this.title = this.title + ' ( Ctrl + b )';
      this.shortcut = 'ctrl+b';
    }
    return BoldButton.__super__._init.call(this);
  };

  BoldButton.prototype._activeStatus = function() {
    var active;
    active = document.queryCommandState('bold') === true;
    this.setActive(active);
    return this.active;
  };

  BoldButton.prototype.command = function() {
    document.execCommand('bold');
    if (!this.editor.util.support.oninput) {
      this.editor.trigger('valuechanged');
    }
    return $(document).trigger('selectionchange');
  };

  return BoldButton;

})(Button);

Simditor.Toolbar.addButton(BoldButton);

ItalicButton = (function(superClass) {
  extend(ItalicButton, superClass);

  function ItalicButton() {
    return ItalicButton.__super__.constructor.apply(this, arguments);
  }

  ItalicButton.prototype.name = 'italic';

  ItalicButton.prototype.icon = 'italic';

  ItalicButton.prototype.htmlTag = 'i';

  ItalicButton.prototype.disableTag = 'pre';

  ItalicButton.prototype.shortcut = 'cmd+i';

  ItalicButton.prototype._init = function() {
    if (this.editor.util.os.mac) {
      this.title = this.title + " ( Cmd + i )";
    } else {
      this.title = this.title + " ( Ctrl + i )";
      this.shortcut = 'ctrl+i';
    }
    return ItalicButton.__super__._init.call(this);
  };

  ItalicButton.prototype._activeStatus = function() {
    var active;
    active = document.queryCommandState('italic') === true;
    this.setActive(active);
    return this.active;
  };

  ItalicButton.prototype.command = function() {
    document.execCommand('italic');
    if (!this.editor.util.support.oninput) {
      this.editor.trigger('valuechanged');
    }
    return $(document).trigger('selectionchange');
  };

  return ItalicButton;

})(Button);

Simditor.Toolbar.addButton(ItalicButton);

UnderlineButton = (function(superClass) {
  extend(UnderlineButton, superClass);

  function UnderlineButton() {
    return UnderlineButton.__super__.constructor.apply(this, arguments);
  }

  UnderlineButton.prototype.name = 'underline';

  UnderlineButton.prototype.icon = 'underline';

  UnderlineButton.prototype.htmlTag = 'u';

  UnderlineButton.prototype.disableTag = 'pre';

  UnderlineButton.prototype.shortcut = 'cmd+u';

  UnderlineButton.prototype.render = function() {
    if (this.editor.util.os.mac) {
      this.title = this.title + ' ( Cmd + u )';
    } else {
      this.title = this.title + ' ( Ctrl + u )';
      this.shortcut = 'ctrl+u';
    }
    return UnderlineButton.__super__.render.call(this);
  };

  UnderlineButton.prototype._activeStatus = function() {
    var active;
    active = document.queryCommandState('underline') === true;
    this.setActive(active);
    return this.active;
  };

  UnderlineButton.prototype.command = function() {
    document.execCommand('underline');
    if (!this.editor.util.support.oninput) {
      this.editor.trigger('valuechanged');
    }
    return $(document).trigger('selectionchange');
  };

  return UnderlineButton;

})(Button);

Simditor.Toolbar.addButton(UnderlineButton);

ColorButton = (function(superClass) {
  extend(ColorButton, superClass);

  function ColorButton() {
    return ColorButton.__super__.constructor.apply(this, arguments);
  }

  ColorButton.prototype.name = 'color';

  ColorButton.prototype.icon = 'tint';

  ColorButton.prototype.disableTag = 'pre';

  ColorButton.prototype.menu = true;

  ColorButton.prototype.render = function() {
    var args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    return ColorButton.__super__.render.apply(this, args);
  };

  ColorButton.prototype.renderMenu = function() {
    $('<ul class="color-list">\n  <li><a href="javascript:;" class="font-color font-color-1"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-2"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-3"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-4"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-5"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-6"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-7"></a></li>\n  <li><a href="javascript:;" class="font-color font-color-default"></a></li>\n</ul>').appendTo(this.menuWrapper);
    this.menuWrapper.on('mousedown', '.color-list', function(e) {
      return false;
    });
    return this.menuWrapper.on('click', '.font-color', (function(_this) {
      return function(e) {
        var $link, $p, hex, range, rgb, textNode;
        _this.wrapper.removeClass('menu-on');
        $link = $(e.currentTarget);
        if ($link.hasClass('font-color-default')) {
          $p = _this.editor.body.find('p, li');
          if (!($p.length > 0)) {
            return;
          }
          rgb = window.getComputedStyle($p[0], null).getPropertyValue('color');
          hex = _this._convertRgbToHex(rgb);
        } else {
          rgb = window.getComputedStyle($link[0], null).getPropertyValue('background-color');
          hex = _this._convertRgbToHex(rgb);
        }
        if (!hex) {
          return;
        }
        range = _this.editor.selection.range();
        if (!$link.hasClass('font-color-default') && range.collapsed) {
          textNode = document.createTextNode(_this._t('coloredText'));
          range.insertNode(textNode);
          range.selectNodeContents(textNode);
        }
        _this.editor.selection.range(range);
        document.execCommand('styleWithCSS', false, true);
        document.execCommand('foreColor', false, hex);
        document.execCommand('styleWithCSS', false, false);
        if (!_this.editor.util.support.oninput) {
          return _this.editor.trigger('valuechanged');
        }
      };
    })(this));
  };

  ColorButton.prototype._convertRgbToHex = function(rgb) {
    var match, re, rgbToHex;
    re = /rgb\((\d+),\s?(\d+),\s?(\d+)\)/g;
    match = re.exec(rgb);
    if (!match) {
      return '';
    }
    rgbToHex = function(r, g, b) {
      var componentToHex;
      componentToHex = function(c) {
        var hex;
        hex = c.toString(16);
        if (hex.length === 1) {
          return '0' + hex;
        } else {
          return hex;
        }
      };
      return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
    };
    return rgbToHex(match[1] * 1, match[2] * 1, match[3] * 1);
  };

  return ColorButton;

})(Button);

Simditor.Toolbar.addButton(ColorButton);

ListButton = (function(superClass) {
  extend(ListButton, superClass);

  function ListButton() {
    return ListButton.__super__.constructor.apply(this, arguments);
  }

  ListButton.prototype.type = '';

  ListButton.prototype.disableTag = 'pre, table';

  ListButton.prototype.command = function(param) {
    var $list, $rootNodes, anotherType;
    $rootNodes = this.editor.selection.blockNodes();
    anotherType = this.type === 'ul' ? 'ol' : 'ul';
    this.editor.selection.save();
    $list = null;
    $rootNodes.each((function(_this) {
      return function(i, node) {
        var $node;
        $node = $(node);
        if ($node.is('blockquote, li') || $node.is(_this.disableTag) || _this.editor.util.isDecoratedNode($node) || !$.contains(document, node)) {
          return;
        }
        if ($node.is(_this.type)) {
          $node.children('li').each(function(i, li) {
            var $childList, $li;
            $li = $(li);
            $childList = $li.children('ul, ol').insertAfter($node);
            return $('<p/>').append($(li).html() || _this.editor.util.phBr).insertBefore($node);
          });
          return $node.remove();
        } else if ($node.is(anotherType)) {
          return $('<' + _this.type + '/>').append($node.contents()).replaceAll($node);
        } else if ($list && $node.prev().is($list)) {
          $('<li/>').append($node.html() || _this.editor.util.phBr).appendTo($list);
          return $node.remove();
        } else {
          $list = $("<" + _this.type + "><li></li></" + _this.type + ">");
          $list.find('li').append($node.html() || _this.editor.util.phBr);
          return $list.replaceAll($node);
        }
      };
    })(this));
    this.editor.selection.restore();
    return this.editor.trigger('valuechanged');
  };

  return ListButton;

})(Button);

OrderListButton = (function(superClass) {
  extend(OrderListButton, superClass);

  function OrderListButton() {
    return OrderListButton.__super__.constructor.apply(this, arguments);
  }

  OrderListButton.prototype.type = 'ol';

  OrderListButton.prototype.name = 'ol';

  OrderListButton.prototype.icon = 'list-ol';

  OrderListButton.prototype.htmlTag = 'ol';

  OrderListButton.prototype.shortcut = 'cmd+/';

  OrderListButton.prototype._init = function() {
    if (this.editor.util.os.mac) {
      this.title = this.title + ' ( Cmd + / )';
    } else {
      this.title = this.title + ' ( ctrl + / )';
      this.shortcut = 'ctrl+/';
    }
    return OrderListButton.__super__._init.call(this);
  };

  return OrderListButton;

})(ListButton);

UnorderListButton = (function(superClass) {
  extend(UnorderListButton, superClass);

  function UnorderListButton() {
    return UnorderListButton.__super__.constructor.apply(this, arguments);
  }

  UnorderListButton.prototype.type = 'ul';

  UnorderListButton.prototype.name = 'ul';

  UnorderListButton.prototype.icon = 'list-ul';

  UnorderListButton.prototype.htmlTag = 'ul';

  UnorderListButton.prototype.shortcut = 'cmd+.';

  UnorderListButton.prototype._init = function() {
    if (this.editor.util.os.mac) {
      this.title = this.title + ' ( Cmd + . )';
    } else {
      this.title = this.title + ' ( Ctrl + . )';
      this.shortcut = 'ctrl+.';
    }
    return UnorderListButton.__super__._init.call(this);
  };

  return UnorderListButton;

})(ListButton);

Simditor.Toolbar.addButton(OrderListButton);

Simditor.Toolbar.addButton(UnorderListButton);

BlockquoteButton = (function(superClass) {
  extend(BlockquoteButton, superClass);

  function BlockquoteButton() {
    return BlockquoteButton.__super__.constructor.apply(this, arguments);
  }

  BlockquoteButton.prototype.name = 'blockquote';

  BlockquoteButton.prototype.icon = 'quote-left';

  BlockquoteButton.prototype.htmlTag = 'blockquote';

  BlockquoteButton.prototype.disableTag = 'pre, table';

  BlockquoteButton.prototype.command = function() {
    var $rootNodes, clearCache, nodeCache;
    $rootNodes = this.editor.selection.rootNodes();
    $rootNodes = $rootNodes.filter(function(i, node) {
      return !$(node).parent().is('blockquote');
    });
    this.editor.selection.save();
    nodeCache = [];
    clearCache = (function(_this) {
      return function() {
        if (nodeCache.length > 0) {
          $("<" + _this.htmlTag + "/>").insertBefore(nodeCache[0]).append(nodeCache);
          return nodeCache.length = 0;
        }
      };
    })(this);
    $rootNodes.each((function(_this) {
      return function(i, node) {
        var $node;
        $node = $(node);
        if (!$node.parent().is(_this.editor.body)) {
          return;
        }
        if ($node.is(_this.htmlTag)) {
          clearCache();
          return $node.children().unwrap();
        } else if ($node.is(_this.disableTag) || _this.editor.util.isDecoratedNode($node)) {
          return clearCache();
        } else {
          return nodeCache.push(node);
        }
      };
    })(this));
    clearCache();
    this.editor.selection.restore();
    return this.editor.trigger('valuechanged');
  };

  return BlockquoteButton;

})(Button);

Simditor.Toolbar.addButton(BlockquoteButton);

CodeButton = (function(superClass) {
  extend(CodeButton, superClass);

  function CodeButton() {
    return CodeButton.__super__.constructor.apply(this, arguments);
  }

  CodeButton.prototype.name = 'code';

  CodeButton.prototype.icon = 'code';

  CodeButton.prototype.htmlTag = 'pre';

  CodeButton.prototype.disableTag = 'ul, ol, table';

  CodeButton.prototype._init = function() {
    CodeButton.__super__._init.call(this);
    this.editor.on('decorate', (function(_this) {
      return function(e, $el) {
        return $el.find('pre').each(function(i, pre) {
          return _this.decorate($(pre));
        });
      };
    })(this));
    return this.editor.on('undecorate', (function(_this) {
      return function(e, $el) {
        return $el.find('pre').each(function(i, pre) {
          return _this.undecorate($(pre));
        });
      };
    })(this));
  };

  CodeButton.prototype.render = function() {
    var args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    CodeButton.__super__.render.apply(this, args);
    return this.popover = new CodePopover({
      button: this
    });
  };

  CodeButton.prototype._checkMode = function() {
    var $blockNodes, range;
    range = this.editor.selection.range();
    if (($blockNodes = $(range.cloneContents()).find(this.editor.util.blockNodes.join(','))) > 0 || (range.collapsed && this.editor.selection.startNodes().filter('code').length === 0)) {
      this.inlineMode = false;
      return this.htmlTag = 'pre';
    } else {
      this.inlineMode = true;
      return this.htmlTag = 'code';
    }
  };

  CodeButton.prototype._status = function() {
    this._checkMode();
    CodeButton.__super__._status.call(this);
    if (this.inlineMode) {
      return;
    }
    if (this.active) {
      return this.popover.show(this.node);
    } else {
      return this.popover.hide();
    }
  };

  CodeButton.prototype.decorate = function($pre) {
    var $code, lang, ref, ref1;
    $code = $pre.find('> code');
    if ($code.length > 0) {
      lang = (ref = $code.attr('class')) != null ? (ref1 = ref.match(/lang-(\S+)/)) != null ? ref1[1] : void 0 : void 0;
      $code.contents().unwrap();
      if (lang) {
        return $pre.attr('data-lang', lang);
      }
    }
  };

  CodeButton.prototype.undecorate = function($pre) {
    var $code, lang;
    lang = $pre.attr('data-lang');
    $code = $('<code/>');
    if (lang && lang !== -1) {
      $code.addClass('lang-' + lang);
    }
    return $pre.wrapInner($code).removeAttr('data-lang');
  };

  CodeButton.prototype.command = function() {
    if (this.inlineMode) {
      return this._inlineCommand();
    } else {
      return this._blockCommand();
    }
  };

  CodeButton.prototype._blockCommand = function() {
    var $rootNodes, clearCache, nodeCache, resultNodes;
    $rootNodes = this.editor.selection.rootNodes();
    nodeCache = [];
    resultNodes = [];
    clearCache = (function(_this) {
      return function() {
        var $pre;
        if (!(nodeCache.length > 0)) {
          return;
        }
        $pre = $("<" + _this.htmlTag + "/>").insertBefore(nodeCache[0]).text(_this.editor.formatter.clearHtml(nodeCache));
        resultNodes.push($pre[0]);
        return nodeCache.length = 0;
      };
    })(this);
    $rootNodes.each((function(_this) {
      return function(i, node) {
        var $node, $p;
        $node = $(node);
        if ($node.is(_this.htmlTag)) {
          clearCache();
          $p = $('<p/>').append($node.html().replace('\n', '<br/>')).replaceAll($node);
          return resultNodes.push($p[0]);
        } else if ($node.is(_this.disableTag) || _this.editor.util.isDecoratedNode($node) || $node.is('blockquote')) {
          return clearCache();
        } else {
          return nodeCache.push(node);
        }
      };
    })(this));
    clearCache();
    this.editor.selection.setRangeAtEndOf($(resultNodes).last());
    return this.editor.trigger('valuechanged');
  };

  CodeButton.prototype._inlineCommand = function() {
    var $code, $contents, range;
    range = this.editor.selection.range();
    if (this.active) {
      range.selectNodeContents(this.node[0]);
      this.editor.selection.save(range);
      this.node.contents().unwrap();
      this.editor.selection.restore();
    } else {
      $contents = $(range.extractContents());
      $code = $("<" + this.htmlTag + "/>").append($contents.contents());
      range.insertNode($code[0]);
      range.selectNodeContents($code[0]);
      this.editor.selection.range(range);
    }
    return this.editor.trigger('valuechanged');
  };

  return CodeButton;

})(Button);

CodePopover = (function(superClass) {
  extend(CodePopover, superClass);

  function CodePopover() {
    return CodePopover.__super__.constructor.apply(this, arguments);
  }

  CodePopover.prototype.render = function() {
    var $option, k, lang, len, ref;
    this._tpl = "<div class=\"code-settings\">\n  <div class=\"settings-field\">\n    <select class=\"select-lang\">\n      <option value=\"-1\">" + (this._t('selectLanguage')) + "</option>\n    </select>\n  </div>\n</div>";
    this.langs = this.editor.opts.codeLanguages || [
      {
        name: 'Bash',
        value: 'bash'
      }, {
        name: 'C++',
        value: 'c++'
      }, {
        name: 'C#',
        value: 'cs'
      }, {
        name: 'CSS',
        value: 'css'
      }, {
        name: 'Erlang',
        value: 'erlang'
      }, {
        name: 'Less',
        value: 'less'
      }, {
        name: 'Sass',
        value: 'sass'
      }, {
        name: 'Diff',
        value: 'diff'
      }, {
        name: 'CoffeeScript',
        value: 'coffeescript'
      }, {
        name: 'HTML,XML',
        value: 'html'
      }, {
        name: 'JSON',
        value: 'json'
      }, {
        name: 'Java',
        value: 'java'
      }, {
        name: 'JavaScript',
        value: 'js'
      }, {
        name: 'Markdown',
        value: 'markdown'
      }, {
        name: 'Objective C',
        value: 'oc'
      }, {
        name: 'PHP',
        value: 'php'
      }, {
        name: 'Perl',
        value: 'parl'
      }, {
        name: 'Python',
        value: 'python'
      }, {
        name: 'Ruby',
        value: 'ruby'
      }, {
        name: 'SQL',
        value: 'sql'
      }
    ];
    this.el.addClass('code-popover').append(this._tpl);
    this.selectEl = this.el.find('.select-lang');
    ref = this.langs;
    for (k = 0, len = ref.length; k < len; k++) {
      lang = ref[k];
      $option = $('<option/>', {
        text: lang.name,
        value: lang.value
      }).appendTo(this.selectEl);
    }
    this.selectEl.on('change', (function(_this) {
      return function(e) {
        var selected;
        _this.lang = _this.selectEl.val();
        selected = _this.target.hasClass('selected');
        _this.target.removeClass().removeAttr('data-lang');
        if (_this.lang !== -1) {
          _this.target.attr('data-lang', _this.lang);
        }
        if (selected) {
          _this.target.addClass('selected');
        }
        return _this.editor.trigger('valuechanged');
      };
    })(this));
    return this.editor.on('valuechanged', (function(_this) {
      return function(e) {
        if (_this.active) {
          return _this.refresh();
        }
      };
    })(this));
  };

  CodePopover.prototype.show = function() {
    var args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    CodePopover.__super__.show.apply(this, args);
    this.lang = this.target.attr('data-lang');
    if (this.lang != null) {
      return this.selectEl.val(this.lang);
    } else {
      return this.selectEl.val(-1);
    }
  };

  return CodePopover;

})(Popover);

Simditor.Toolbar.addButton(CodeButton);

LinkButton = (function(superClass) {
  extend(LinkButton, superClass);

  function LinkButton() {
    return LinkButton.__super__.constructor.apply(this, arguments);
  }

  LinkButton.prototype.name = 'link';

  LinkButton.prototype.icon = 'link';

  LinkButton.prototype.htmlTag = 'a';

  LinkButton.prototype.disableTag = 'pre';

  LinkButton.prototype.render = function() {
    var args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    LinkButton.__super__.render.apply(this, args);
    return this.popover = new LinkPopover({
      button: this
    });
  };

  LinkButton.prototype._status = function() {
    LinkButton.__super__._status.call(this);
    if (this.active && !this.editor.selection.rangeAtEndOf(this.node)) {
      return this.popover.show(this.node);
    } else {
      return this.popover.hide();
    }
  };

  LinkButton.prototype.command = function() {
    var $contents, $link, $newBlock, linkText, range, txtNode;
    range = this.editor.selection.range();
    if (this.active) {
      txtNode = document.createTextNode(this.node.text());
      this.node.replaceWith(txtNode);
      range.selectNode(txtNode);
    } else {
      $contents = $(range.extractContents());
      linkText = this.editor.formatter.clearHtml($contents.contents(), false);
      $link = $('<a/>', {
        href: '',
        target: '_blank',
        text: linkText || this._t('linkText')
      });
      if (this.editor.selection.blockNodes().length > 0) {
        range.insertNode($link[0]);
      } else {
        $newBlock = $('<p/>').append($link);
        range.insertNode($newBlock[0]);
      }
      range.selectNodeContents($link[0]);
      this.popover.one('popovershow', (function(_this) {
        return function() {
          if (linkText) {
            _this.popover.urlEl.focus();
            return _this.popover.urlEl[0].select();
          } else {
            _this.popover.textEl.focus();
            return _this.popover.textEl[0].select();
          }
        };
      })(this));
    }
    this.editor.selection.range(range);
    return this.editor.trigger('valuechanged');
  };

  return LinkButton;

})(Button);

LinkPopover = (function(superClass) {
  extend(LinkPopover, superClass);

  function LinkPopover() {
    return LinkPopover.__super__.constructor.apply(this, arguments);
  }

  LinkPopover.prototype.render = function() {
    var tpl;
    tpl = "<div class=\"link-settings\">\n  <div class=\"settings-field\">\n    <label>" + (this._t('linkText')) + "</label>\n    <input class=\"link-text\" type=\"text\"/>\n    <a class=\"btn-unlink\" href=\"javascript:;\" title=\"" + (this._t('removeLink')) + "\"\n      tabindex=\"-1\">\n      <span class=\"simditor-icon simditor-icon-unlink\"></span>\n    </a>\n  </div>\n  <div class=\"settings-field\">\n    <label>" + (this._t('linkUrl')) + "</label>\n    <input class=\"link-url\" type=\"text\"/>\n  </div>\n  <div class=\"settings-field\">\n    <label>" + (this._t('linkTarget')) + "</label>\n    <select class=\"link-target\">\n      <option value=\"_blank\">" + (this._t('openLinkInNewWindow')) + " (_blank)</option>\n      <option value=\"_self\">" + (this._t('openLinkInCurrentWindow')) + " (_self)</option>\n    </select>\n  </div>\n</div>";
    this.el.addClass('link-popover').append(tpl);
    this.textEl = this.el.find('.link-text');
    this.urlEl = this.el.find('.link-url');
    this.unlinkEl = this.el.find('.btn-unlink');
    this.selectTarget = this.el.find('.link-target');
    this.textEl.on('keyup', (function(_this) {
      return function(e) {
        if (e.which === 13) {
          return;
        }
        _this.target.text(_this.textEl.val());
        return _this.editor.inputManager.throttledValueChanged();
      };
    })(this));
    this.urlEl.on('keyup', (function(_this) {
      return function(e) {
        var val;
        if (e.which === 13) {
          return;
        }
        val = _this.urlEl.val();
        if (!(/^(http|https|ftp|ftps|file)?:\/\/|^(mailto|tel)?:|^\//ig.test(val) || !val)) {
          val = 'http://' + val;
        }
        _this.target.attr('href', val);
        return _this.editor.inputManager.throttledValueChanged();
      };
    })(this));
    $([this.urlEl[0], this.textEl[0]]).on('keydown', (function(_this) {
      return function(e) {
        var range;
        if (e.which === 13 || e.which === 27 || (!e.shiftKey && e.which === 9 && $(e.target).hasClass('link-url'))) {
          e.preventDefault();
          range = document.createRange();
          _this.editor.selection.setRangeAfter(_this.target, range);
          _this.hide();
          return _this.editor.inputManager.throttledValueChanged();
        }
      };
    })(this));
    this.unlinkEl.on('click', (function(_this) {
      return function(e) {
        var range, txtNode;
        txtNode = document.createTextNode(_this.target.text());
        _this.target.replaceWith(txtNode);
        _this.hide();
        range = document.createRange();
        _this.editor.selection.setRangeAfter(txtNode, range);
        return _this.editor.inputManager.throttledValueChanged();
      };
    })(this));
    return this.selectTarget.on('change', (function(_this) {
      return function(e) {
        _this.target.attr('target', _this.selectTarget.val());
        return _this.editor.inputManager.throttledValueChanged();
      };
    })(this));
  };

  LinkPopover.prototype.show = function() {
    var args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    LinkPopover.__super__.show.apply(this, args);
    this.textEl.val(this.target.text());
    return this.urlEl.val(this.target.attr('href'));
  };

  return LinkPopover;

})(Popover);

Simditor.Toolbar.addButton(LinkButton);

ImageButton = (function(superClass) {
  extend(ImageButton, superClass);

  function ImageButton() {
    return ImageButton.__super__.constructor.apply(this, arguments);
  }

  ImageButton.prototype.name = 'image';

  ImageButton.prototype.icon = 'picture-o';

  ImageButton.prototype.htmlTag = 'img';

  ImageButton.prototype.disableTag = 'pre, table';

  ImageButton.prototype.defaultImage = '';

  ImageButton.prototype.needFocus = false;

  ImageButton.prototype._init = function() {
    var item, k, len, ref;
    if (this.editor.opts.imageButton) {
      if (Array.isArray(this.editor.opts.imageButton)) {
        this.menu = [];
        ref = this.editor.opts.imageButton;
        for (k = 0, len = ref.length; k < len; k++) {
          item = ref[k];
          this.menu.push({
            name: item + '-image',
            text: this._t(item + 'Image')
          });
        }
      } else {
        this.menu = false;
      }
    } else {
      if (this.editor.uploader != null) {
        this.menu = [
          {
            name: 'upload-image',
            text: this._t('uploadImage')
          }, {
            name: 'external-image',
            text: this._t('externalImage')
          }
        ];
      } else {
        this.menu = false;
      }
    }
    this.defaultImage = this.editor.opts.defaultImage;
    this.editor.body.on('click', 'img:not([data-non-image])', (function(_this) {
      return function(e) {
        var $img, range;
        $img = $(e.currentTarget);
        range = document.createRange();
        range.selectNode($img[0]);
        _this.editor.selection.range(range);
        if (!_this.editor.util.support.onselectionchange) {
          _this.editor.trigger('selectionchanged');
        }
        return false;
      };
    })(this));
    this.editor.body.on('mouseup', 'img:not([data-non-image])', function(e) {
      return false;
    });
    this.editor.on('selectionchanged.image', (function(_this) {
      return function() {
        var $contents, $img, range;
        range = _this.editor.selection.range();
        if (range == null) {
          return;
        }
        $contents = $(range.cloneContents()).contents();
        if ($contents.length === 1 && $contents.is('img:not([data-non-image])')) {
          $img = $(range.startContainer).contents().eq(range.startOffset);
          return _this.popover.show($img);
        } else {
          return _this.popover.hide();
        }
      };
    })(this));
    this.editor.on('valuechanged.image', (function(_this) {
      return function() {
        var $masks;
        $masks = _this.editor.wrapper.find('.simditor-image-loading');
        if (!($masks.length > 0)) {
          return;
        }
        return $masks.each(function(i, mask) {
          var $img, $mask, file;
          $mask = $(mask);
          $img = $mask.data('img');
          if (!($img && $img.parent().length > 0)) {
            $mask.remove();
            if ($img) {
              file = $img.data('file');
              if (file) {
                _this.editor.uploader.cancel(file);
                if (_this.editor.body.find('img.uploading').length < 1) {
                  return _this.editor.uploader.trigger('uploadready', [file]);
                }
              }
            }
          }
        });
      };
    })(this));
    return ImageButton.__super__._init.call(this);
  };

  ImageButton.prototype.render = function() {
    var args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    ImageButton.__super__.render.apply(this, args);
    this.popover = new ImagePopover({
      button: this
    });
    if (this.editor.opts.imageButton === 'upload') {
      return this._initUploader(this.el);
    }
  };

  ImageButton.prototype.renderMenu = function() {
    ImageButton.__super__.renderMenu.call(this);
    return this._initUploader();
  };

  ImageButton.prototype._initUploader = function($uploadItem) {
    var $input, createInput, uploadProgress;
    if ($uploadItem == null) {
      $uploadItem = this.menuEl.find('.menu-item-upload-image');
    }
    if (this.editor.uploader == null) {
      this.el.find('.btn-upload').remove();
      return;
    }
    $input = null;
    createInput = (function(_this) {
      return function() {
        if ($input) {
          $input.remove();
        }
        return $input = $('<input/>', {
          type: 'file',
          title: _this._t('uploadImage'),
          multiple: true,
          accept: 'image/gif,image/jpeg,image/jpg,image/png,image/svg'
        }).appendTo($uploadItem);
      };
    })(this);
    createInput();
    $uploadItem.on('click mousedown', 'input[type=file]', function(e) {
      return e.stopPropagation();
    });
    $uploadItem.on('change', 'input[type=file]', (function(_this) {
      return function(e) {
        if (_this.editor.inputManager.focused) {
          _this.editor.uploader.upload($input, {
            inline: true
          });
          createInput();
        } else {
          _this.editor.one('focus', function(e) {
            _this.editor.uploader.upload($input, {
              inline: true
            });
            return createInput();
          });
          _this.editor.focus();
        }
        return _this.wrapper.removeClass('menu-on');
      };
    })(this));
    this.editor.uploader.on('beforeupload', (function(_this) {
      return function(e, file) {
        var $img;
        if (!file.inline) {
          return;
        }
        if (file.img) {
          $img = $(file.img);
        } else {
          $img = _this.createImage(file.name);
          file.img = $img;
        }
        $img.addClass('uploading');
        $img.data('file', file);
        return _this.editor.uploader.readImageFile(file.obj, function(img) {
          var src;
          if (!$img.hasClass('uploading')) {
            return;
          }
          src = img ? img.src : _this.defaultImage;
          return _this.loadImage($img, src, function() {
            if (_this.popover.active) {
              _this.popover.refresh();
              return _this.popover.srcEl.val(_this._t('uploading')).prop('disabled', true);
            }
          });
        });
      };
    })(this));
    uploadProgress = $.proxy(this.editor.util.throttle(function(e, file, loaded, total) {
      var $img, $mask, percent;
      if (!file.inline) {
        return;
      }
      $mask = file.img.data('mask');
      if (!$mask) {
        return;
      }
      $img = $mask.data('img');
      if (!($img.hasClass('uploading') && $img.parent().length > 0)) {
        $mask.remove();
        return;
      }
      percent = loaded / total;
      percent = (percent * 100).toFixed(0);
      if (percent > 99) {
        percent = 99;
      }
      return $mask.find('.progress').height((100 - percent) + "%");
    }, 500), this);
    this.editor.uploader.on('uploadprogress', uploadProgress);
    this.editor.uploader.on('uploadsuccess', (function(_this) {
      return function(e, file, result) {
        var $img, img_path, msg;
        if (!file.inline) {
          return;
        }
        $img = file.img;
        if (!($img.hasClass('uploading') && $img.parent().length > 0)) {
          return;
        }
        if (typeof result !== 'object') {
          try {
            result = $.parseJSON(result);
          } catch (_error) {
            e = _error;
            result = {
              success: false
            };
          }
        }
        if (result.success === false) {
          msg = result.msg || _this._t('uploadFailed');
          alert(msg);
          img_path = _this.defaultImage;
        } else {
          img_path = result.file_path;
        }
        _this.loadImage($img, img_path, function() {
          var $mask;
          $img.removeData('file');
          $img.removeClass('uploading').removeClass('loading');
          $mask = $img.data('mask');
          if ($mask) {
            $mask.remove();
          }
          $img.removeData('mask');
          _this.editor.trigger('valuechanged');
          if (_this.editor.body.find('img.uploading').length < 1) {
            return _this.editor.uploader.trigger('uploadready', [file, result]);
          }
        });
        if (_this.popover.active) {
          _this.popover.srcEl.prop('disabled', false);
          return _this.popover.srcEl.val(result.file_path);
        }
      };
    })(this));
    return this.editor.uploader.on('uploaderror', (function(_this) {
      return function(e, file, xhr) {
        var $img, msg, result;
        if (!file.inline) {
          return;
        }
        if (xhr.statusText === 'abort') {
          return;
        }
        if (xhr.responseText) {
          try {
            result = $.parseJSON(xhr.responseText);
            msg = result.msg;
          } catch (_error) {
            e = _error;
            msg = _this._t('uploadError');
          }
        }
        $img = file.img;
        if (!($img.hasClass('uploading') && $img.parent().length > 0)) {
          return;
        }
        _this.loadImage($img, _this.defaultImage, function() {
          var $mask;
          $img.removeData('file');
          $img.removeClass('uploading').removeClass('loading');
          $mask = $img.data('mask');
          if ($mask) {
            $mask.remove();
          }
          return $img.removeData('mask');
        });
        if (_this.popover.active) {
          _this.popover.srcEl.prop('disabled', false);
          _this.popover.srcEl.val(_this.defaultImage);
        }
        _this.editor.trigger('valuechanged');
        if (_this.editor.body.find('img.uploading').length < 1) {
          return _this.editor.uploader.trigger('uploadready', [file, result]);
        }
      };
    })(this));
  };

  ImageButton.prototype._status = function() {
    return this._disableStatus();
  };

  ImageButton.prototype.loadImage = function($img, src, callback) {
    var $mask, img, positionMask;
    positionMask = (function(_this) {
      return function() {
        var imgOffset, wrapperOffset;
        imgOffset = $img.offset();
        wrapperOffset = _this.editor.wrapper.offset();
        return $mask.css({
          top: imgOffset.top - wrapperOffset.top,
          left: imgOffset.left - wrapperOffset.left,
          width: $img.width(),
          height: $img.height()
        }).show();
      };
    })(this);
    $img.addClass('loading');
    $mask = $img.data('mask');
    if (!$mask) {
      $mask = $('<div class="simditor-image-loading">\n  <div class="progress"></div>\n</div>').hide().appendTo(this.editor.wrapper);
      positionMask();
      $img.data('mask', $mask);
      $mask.data('img', $img);
    }
    img = new Image();
    img.onload = (function(_this) {
      return function() {
        var height, width;
        if (!$img.hasClass('loading') && !$img.hasClass('uploading')) {
          return;
        }
        width = img.width;
        height = img.height;
        $img.attr({
          src: src,
          width: width,
          height: height,
          'data-image-size': width + ',' + height
        }).removeClass('loading');
        if ($img.hasClass('uploading')) {
          _this.editor.util.reflow(_this.editor.body);
          positionMask();
        } else {
          $mask.remove();
          $img.removeData('mask');
        }
        if ($.isFunction(callback)) {
          return callback(img);
        }
      };
    })(this);
    img.onerror = function() {
      if ($.isFunction(callback)) {
        callback(false);
      }
      $mask.remove();
      return $img.removeData('mask').removeClass('loading');
    };
    return img.src = src;
  };

  ImageButton.prototype.createImage = function(name) {
    var $img, range;
    if (name == null) {
      name = 'Image';
    }
    if (!this.editor.inputManager.focused) {
      this.editor.focus();
    }
    range = this.editor.selection.range();
    range.deleteContents();
    this.editor.selection.range(range);
    $img = $('<img/>').attr('alt', name);
    range.insertNode($img[0]);
    this.editor.selection.setRangeAfter($img, range);
    this.editor.trigger('valuechanged');
    return $img;
  };

  ImageButton.prototype.command = function(src) {
    var $img;
    $img = this.createImage();
    return this.loadImage($img, src || this.defaultImage, (function(_this) {
      return function() {
        _this.editor.trigger('valuechanged');
        _this.editor.util.reflow($img);
        $img.click();
        return _this.popover.one('popovershow', function() {
          _this.popover.srcEl.focus();
          return _this.popover.srcEl[0].select();
        });
      };
    })(this));
  };

  return ImageButton;

})(Button);

ImagePopover = (function(superClass) {
  extend(ImagePopover, superClass);

  function ImagePopover() {
    return ImagePopover.__super__.constructor.apply(this, arguments);
  }

  ImagePopover.prototype.offset = {
    top: 6,
    left: -4
  };

  ImagePopover.prototype.render = function() {
    var tpl;
    tpl = "<div class=\"link-settings\">\n  <div class=\"settings-field\">\n    <label>" + (this._t('imageUrl')) + "</label>\n    <input class=\"image-src\" type=\"text\" tabindex=\"1\" />\n    <a class=\"btn-upload\" href=\"javascript:;\"\n      title=\"" + (this._t('uploadImage')) + "\" tabindex=\"-1\">\n      <span class=\"simditor-icon simditor-icon-upload\"></span>\n    </a>\n  </div>\n  <div class='settings-field'>\n    <label>" + (this._t('imageAlt')) + "</label>\n    <input class=\"image-alt\" id=\"image-alt\" type=\"text\" tabindex=\"1\" />\n  </div>\n  <div class=\"settings-field\">\n    <label>" + (this._t('imageSize')) + "</label>\n    <input class=\"image-size\" id=\"image-width\" type=\"text\" tabindex=\"2\" />\n    <span class=\"times\">×</span>\n    <input class=\"image-size\" id=\"image-height\" type=\"text\" tabindex=\"3\" />\n    <a class=\"btn-restore\" href=\"javascript:;\"\n      title=\"" + (this._t('restoreImageSize')) + "\" tabindex=\"-1\">\n      <span class=\"simditor-icon simditor-icon-undo\"></span>\n    </a>\n  </div>\n</div>";
    this.el.addClass('image-popover').append(tpl);
    this.srcEl = this.el.find('.image-src');
    this.widthEl = this.el.find('#image-width');
    this.heightEl = this.el.find('#image-height');
    this.altEl = this.el.find('#image-alt');
    this.srcEl.on('keydown', (function(_this) {
      return function(e) {
        var range;
        if (!(e.which === 13 && !_this.target.hasClass('uploading'))) {
          return;
        }
        e.preventDefault();
        range = document.createRange();
        _this.button.editor.selection.setRangeAfter(_this.target, range);
        return _this.hide();
      };
    })(this));
    this.srcEl.on('blur', (function(_this) {
      return function(e) {
        return _this._loadImage(_this.srcEl.val());
      };
    })(this));
    this.el.find('.image-size').on('blur', (function(_this) {
      return function(e) {
        _this._resizeImg($(e.currentTarget));
        return _this.el.data('popover').refresh();
      };
    })(this));
    this.el.find('.image-size').on('keyup', (function(_this) {
      return function(e) {
        var inputEl;
        inputEl = $(e.currentTarget);
        if (!(e.which === 13 || e.which === 27 || e.which === 9)) {
          return _this._resizeImg(inputEl, true);
        }
      };
    })(this));
    this.el.find('.image-size').on('keydown', (function(_this) {
      return function(e) {
        var $img, inputEl, range;
        inputEl = $(e.currentTarget);
        if (e.which === 13 || e.which === 27) {
          e.preventDefault();
          if (e.which === 13) {
            _this._resizeImg(inputEl);
          } else {
            _this._restoreImg();
          }
          $img = _this.target;
          _this.hide();
          range = document.createRange();
          return _this.button.editor.selection.setRangeAfter($img, range);
        } else if (e.which === 9) {
          return _this.el.data('popover').refresh();
        }
      };
    })(this));
    this.altEl.on('keydown', (function(_this) {
      return function(e) {
        var range;
        if (e.which === 13) {
          e.preventDefault();
          range = document.createRange();
          _this.button.editor.selection.setRangeAfter(_this.target, range);
          return _this.hide();
        }
      };
    })(this));
    this.altEl.on('keyup', (function(_this) {
      return function(e) {
        if (e.which === 13 || e.which === 27 || e.which === 9) {
          return;
        }
        _this.alt = _this.altEl.val();
        return _this.target.attr('alt', _this.alt);
      };
    })(this));
    this.el.find('.btn-restore').on('click', (function(_this) {
      return function(e) {
        _this._restoreImg();
        return _this.el.data('popover').refresh();
      };
    })(this));
    this.editor.on('valuechanged', (function(_this) {
      return function(e) {
        if (_this.active) {
          return _this.refresh();
        }
      };
    })(this));
    return this._initUploader();
  };

  ImagePopover.prototype._initUploader = function() {
    var $uploadBtn, createInput;
    $uploadBtn = this.el.find('.btn-upload');
    if (this.editor.uploader == null) {
      $uploadBtn.remove();
      return;
    }
    createInput = (function(_this) {
      return function() {
        if (_this.input) {
          _this.input.remove();
        }
        return _this.input = $('<input/>', {
          type: 'file',
          title: _this._t('uploadImage'),
          multiple: true,
          accept: 'image/gif,image/jpeg,image/jpg,image/png,image/svg'
        }).appendTo($uploadBtn);
      };
    })(this);
    createInput();
    this.el.on('click mousedown', 'input[type=file]', function(e) {
      return e.stopPropagation();
    });
    return this.el.on('change', 'input[type=file]', (function(_this) {
      return function(e) {
        _this.editor.uploader.upload(_this.input, {
          inline: true,
          img: _this.target
        });
        return createInput();
      };
    })(this));
  };

  ImagePopover.prototype._resizeImg = function(inputEl, onlySetVal) {
    var height, value, width;
    if (onlySetVal == null) {
      onlySetVal = false;
    }
    value = inputEl.val() * 1;
    if (!(this.target && ($.isNumeric(value) || value < 0))) {
      return;
    }
    if (inputEl.is(this.widthEl)) {
      width = value;
      height = this.height * value / this.width;
      this.heightEl.val(height);
    } else {
      height = value;
      width = this.width * value / this.height;
      this.widthEl.val(width);
    }
    if (!onlySetVal) {
      this.target.attr({
        width: width,
        height: height
      });
      return this.editor.trigger('valuechanged');
    }
  };

  ImagePopover.prototype._restoreImg = function() {
    var ref, size;
    size = ((ref = this.target.data('image-size')) != null ? ref.split(",") : void 0) || [this.width, this.height];
    this.target.attr({
      width: size[0] * 1,
      height: size[1] * 1
    });
    this.widthEl.val(size[0]);
    this.heightEl.val(size[1]);
    return this.editor.trigger('valuechanged');
  };

  ImagePopover.prototype._loadImage = function(src, callback) {
    if (/^data:image/.test(src) && !this.editor.uploader) {
      if (callback) {
        callback(false);
      }
      return;
    }
    if (this.target.attr('src') === src) {
      return;
    }
    return this.button.loadImage(this.target, src, (function(_this) {
      return function(img) {
        var blob;
        if (!img) {
          return;
        }
        if (_this.active) {
          _this.width = img.width;
          _this.height = img.height;
          _this.widthEl.val(_this.width);
          _this.heightEl.val(_this.height);
        }
        if (/^data:image/.test(src)) {
          blob = _this.editor.util.dataURLtoBlob(src);
          blob.name = "Base64 Image.png";
          _this.editor.uploader.upload(blob, {
            inline: true,
            img: _this.target
          });
        } else {
          _this.editor.trigger('valuechanged');
        }
        if (callback) {
          return callback(img);
        }
      };
    })(this));
  };

  ImagePopover.prototype.show = function() {
    var $img, args;
    args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    ImagePopover.__super__.show.apply(this, args);
    $img = this.target;
    this.width = $img.width();
    this.height = $img.height();
    this.alt = $img.attr('alt');
    if ($img.hasClass('uploading')) {
      return this.srcEl.val(this._t('uploading')).prop('disabled', true);
    } else {
      this.srcEl.val($img.attr('src')).prop('disabled', false);
      this.widthEl.val(this.width);
      this.heightEl.val(this.height);
      return this.altEl.val(this.alt);
    }
  };

  return ImagePopover;

})(Popover);

Simditor.Toolbar.addButton(ImageButton);

IndentButton = (function(superClass) {
  extend(IndentButton, superClass);

  function IndentButton() {
    return IndentButton.__super__.constructor.apply(this, arguments);
  }

  IndentButton.prototype.name = 'indent';

  IndentButton.prototype.icon = 'indent';

  IndentButton.prototype._init = function() {
    var hotkey;
    hotkey = this.editor.opts.tabIndent === false ? '' : ' (Tab)';
    this.title = this._t(this.name) + hotkey;
    return IndentButton.__super__._init.call(this);
  };

  IndentButton.prototype._status = function() {};

  IndentButton.prototype.command = function() {
    return this.editor.indentation.indent();
  };

  return IndentButton;

})(Button);

Simditor.Toolbar.addButton(IndentButton);

OutdentButton = (function(superClass) {
  extend(OutdentButton, superClass);

  function OutdentButton() {
    return OutdentButton.__super__.constructor.apply(this, arguments);
  }

  OutdentButton.prototype.name = 'outdent';

  OutdentButton.prototype.icon = 'outdent';

  OutdentButton.prototype._init = function() {
    var hotkey;
    hotkey = this.editor.opts.tabIndent === false ? '' : ' (Shift + Tab)';
    this.title = this._t(this.name) + hotkey;
    return OutdentButton.__super__._init.call(this);
  };

  OutdentButton.prototype._status = function() {};

  OutdentButton.prototype.command = function() {
    return this.editor.indentation.indent(true);
  };

  return OutdentButton;

})(Button);

Simditor.Toolbar.addButton(OutdentButton);

HrButton = (function(superClass) {
  extend(HrButton, superClass);

  function HrButton() {
    return HrButton.__super__.constructor.apply(this, arguments);
  }

  HrButton.prototype.name = 'hr';

  HrButton.prototype.icon = 'minus';

  HrButton.prototype.htmlTag = 'hr';

  HrButton.prototype._status = function() {};

  HrButton.prototype.command = function() {
    var $hr, $newBlock, $nextBlock, $rootBlock;
    $rootBlock = this.editor.selection.rootNodes().first();
    $nextBlock = $rootBlock.next();
    if ($nextBlock.length > 0) {
      this.editor.selection.save();
    } else {
      $newBlock = $('<p/>').append(this.editor.util.phBr);
    }
    $hr = $('<hr/>').insertAfter($rootBlock);
    if ($newBlock) {
      $newBlock.insertAfter($hr);
      this.editor.selection.setRangeAtStartOf($newBlock);
    } else {
      this.editor.selection.restore();
    }
    return this.editor.trigger('valuechanged');
  };

  return HrButton;

})(Button);

Simditor.Toolbar.addButton(HrButton);

TableButton = (function(superClass) {
  extend(TableButton, superClass);

  function TableButton() {
    return TableButton.__super__.constructor.apply(this, arguments);
  }

  TableButton.prototype.name = 'table';

  TableButton.prototype.icon = 'table';

  TableButton.prototype.htmlTag = 'table';

  TableButton.prototype.disableTag = 'pre, li, blockquote';

  TableButton.prototype.menu = true;

  TableButton.prototype._init = function() {
    TableButton.__super__._init.call(this);
    $.merge(this.editor.formatter._allowedTags, ['thead', 'th', 'tbody', 'tr', 'td', 'colgroup', 'col']);
    $.extend(this.editor.formatter._allowedAttributes, {
      td: ['rowspan', 'colspan'],
      col: ['width']
    });
    $.extend(this.editor.formatter._allowedStyles, {
      td: ['text-align'],
      th: ['text-align']
    });
    this._initShortcuts();
    this._initResize();
    this.editor.on('decorate', (function(_this) {
      return function(e, $el) {
        return $el.find('table').each(function(i, table) {
          return _this.decorate($(table));
        });
      };
    })(this));
    this.editor.on('undecorate', (function(_this) {
      return function(e, $el) {
        return $el.find('table').each(function(i, table) {
          return _this.undecorate($(table));
        });
      };
    })(this));
    this.editor.on('selectionchanged.table', (function(_this) {
      return function(e) {
        var $container, range;
        _this.editor.body.find('.simditor-table td, .simditor-table th').removeClass('active');
        range = _this.editor.selection.range();
        if (!range) {
          return;
        }
        $container = _this.editor.selection.containerNode();
        if (range.collapsed && $container.is('.simditor-table')) {
          _this.editor.selection.setRangeAtEndOf($container);
        }
        return $container.closest('td, th', _this.editor.body).addClass('active');
      };
    })(this));
    this.editor.on('blur.table', (function(_this) {
      return function(e) {
        return _this.editor.body.find('.simditor-table td, .simditor-table th').removeClass('active');
      };
    })(this));
    this.editor.keystroke.add('up', 'td', (function(_this) {
      return function(e, $node) {
        _this._tdNav($node, 'up');
        return true;
      };
    })(this));
    this.editor.keystroke.add('up', 'th', (function(_this) {
      return function(e, $node) {
        _this._tdNav($node, 'up');
        return true;
      };
    })(this));
    this.editor.keystroke.add('down', 'td', (function(_this) {
      return function(e, $node) {
        _this._tdNav($node, 'down');
        return true;
      };
    })(this));
    return this.editor.keystroke.add('down', 'th', (function(_this) {
      return function(e, $node) {
        _this._tdNav($node, 'down');
        return true;
      };
    })(this));
  };

  TableButton.prototype._tdNav = function($td, direction) {
    var $anotherTr, $tr, action, anotherTag, index, parentTag, ref;
    if (direction == null) {
      direction = 'up';
    }
    action = direction === 'up' ? 'prev' : 'next';
    ref = direction === 'up' ? ['tbody', 'thead'] : ['thead', 'tbody'], parentTag = ref[0], anotherTag = ref[1];
    $tr = $td.parent('tr');
    $anotherTr = this["_" + action + "Row"]($tr);
    if (!($anotherTr.length > 0)) {
      return true;
    }
    index = $tr.find('td, th').index($td);
    return this.editor.selection.setRangeAtEndOf($anotherTr.find('td, th').eq(index));
  };

  TableButton.prototype._nextRow = function($tr) {
    var $nextTr;
    $nextTr = $tr.next('tr');
    if ($nextTr.length < 1 && $tr.parent('thead').length > 0) {
      $nextTr = $tr.parent('thead').next('tbody').find('tr:first');
    }
    return $nextTr;
  };

  TableButton.prototype._prevRow = function($tr) {
    var $prevTr;
    $prevTr = $tr.prev('tr');
    if ($prevTr.length < 1 && $tr.parent('tbody').length > 0) {
      $prevTr = $tr.parent('tbody').prev('thead').find('tr');
    }
    return $prevTr;
  };

  TableButton.prototype._initResize = function() {
    var $editor;
    $editor = this.editor;
    $(document).on('mousemove.simditor-table', '.simditor-table td, .simditor-table th', function(e) {
      var $col, $colgroup, $resizeHandle, $td, $wrapper, index, ref, ref1, x;
      $wrapper = $(this).parents('.simditor-table');
      $resizeHandle = $wrapper.find('.simditor-resize-handle');
      $colgroup = $wrapper.find('colgroup');
      if ($wrapper.hasClass('resizing')) {
        return;
      }
      $td = $(e.currentTarget);
      x = e.pageX - $(e.currentTarget).offset().left;
      if (x < 5 && $td.prev().length > 0) {
        $td = $td.prev();
      }
      if ($td.next('td, th').length < 1) {
        $resizeHandle.hide();
        return;
      }
      if ((ref = $resizeHandle.data('td')) != null ? ref.is($td) : void 0) {
        $resizeHandle.show();
        return;
      }
      index = $td.parent().find('td, th').index($td);
      $col = $colgroup.find('col').eq(index);
      if ((ref1 = $resizeHandle.data('col')) != null ? ref1.is($col) : void 0) {
        $resizeHandle.show();
        return;
      }
      return $resizeHandle.css('left', $td.position().left + $td.outerWidth() - 5).data('td', $td).data('col', $col).show();
    });
    $(document).on('mouseleave.simditor-table', '.simditor-table', function(e) {
      return $(this).find('.simditor-resize-handle').hide();
    });
    return $(document).on('mousedown.simditor-resize-handle', '.simditor-resize-handle', function(e) {
      var $handle, $leftCol, $leftTd, $rightCol, $rightTd, $wrapper, minWidth, startHandleLeft, startLeftWidth, startRightWidth, startX, tableWidth;
      $wrapper = $(this).parent('.simditor-table');
      $handle = $(e.currentTarget);
      $leftTd = $handle.data('td');
      $leftCol = $handle.data('col');
      $rightTd = $leftTd.next('td, th');
      $rightCol = $leftCol.next('col');
      startX = e.pageX;
      startLeftWidth = $leftTd.outerWidth() * 1;
      startRightWidth = $rightTd.outerWidth() * 1;
      startHandleLeft = parseFloat($handle.css('left'));
      tableWidth = $leftTd.closest('table').width();
      minWidth = 50;
      $(document).on('mousemove.simditor-resize-table', function(e) {
        var deltaX, leftWidth, rightWidth;
        deltaX = e.pageX - startX;
        leftWidth = startLeftWidth + deltaX;
        rightWidth = startRightWidth - deltaX;
        if (leftWidth < minWidth) {
          leftWidth = minWidth;
          deltaX = minWidth - startLeftWidth;
          rightWidth = startRightWidth - deltaX;
        } else if (rightWidth < minWidth) {
          rightWidth = minWidth;
          deltaX = startRightWidth - minWidth;
          leftWidth = startLeftWidth + deltaX;
        }
        $leftCol.attr('width', (leftWidth / tableWidth * 100) + '%');
        $rightCol.attr('width', (rightWidth / tableWidth * 100) + '%');
        return $handle.css('left', startHandleLeft + deltaX);
      });
      $(document).one('mouseup.simditor-resize-table', function(e) {
        $editor.sync();
        $(document).off('.simditor-resize-table');
        return $wrapper.removeClass('resizing');
      });
      $wrapper.addClass('resizing');
      return false;
    });
  };

  TableButton.prototype._initShortcuts = function() {
    this.editor.hotkeys.add('ctrl+alt+up', (function(_this) {
      return function(e) {
        _this.editMenu.find('.menu-item[data-param=insertRowAbove]').click();
        return false;
      };
    })(this));
    this.editor.hotkeys.add('ctrl+alt+down', (function(_this) {
      return function(e) {
        _this.editMenu.find('.menu-item[data-param=insertRowBelow]').click();
        return false;
      };
    })(this));
    this.editor.hotkeys.add('ctrl+alt+left', (function(_this) {
      return function(e) {
        _this.editMenu.find('.menu-item[data-param=insertColLeft]').click();
        return false;
      };
    })(this));
    return this.editor.hotkeys.add('ctrl+alt+right', (function(_this) {
      return function(e) {
        _this.editMenu.find('.menu-item[data-param=insertColRight]').click();
        return false;
      };
    })(this));
  };

  TableButton.prototype.decorate = function($table) {
    var $colgroup, $headRow, $resizeHandle, $tbody, $thead, $wrapper;
    if ($table.parent('.simditor-table').length > 0) {
      this.undecorate($table);
    }
    $table.wrap('<div class="simditor-table"></div>');
    $wrapper = $table.parent('.simditor-table');
    $colgroup = $table.find('colgroup');
    if ($table.find('thead').length < 1) {
      $thead = $('<thead />');
      $headRow = $table.find('tr').first();
      $thead.append($headRow);
      this._changeCellTag($headRow, 'th');
      $tbody = $table.find('tbody');
      if ($tbody.length > 0) {
        $tbody.before($thead);
      } else {
        $table.prepend($thead);
      }
    }
    if ($colgroup.length < 1) {
      $colgroup = $('<colgroup/>').prependTo($table);
      $table.find('thead tr th').each(function(i, td) {
        var $col;
        return $col = $('<col/>').appendTo($colgroup);
      });
      this.refreshTableWidth($table);
    }
    $resizeHandle = $('<div />', {
      "class": 'simditor-resize-handle',
      contenteditable: 'false'
    }).appendTo($wrapper);
    return $table.parent();
  };

  TableButton.prototype.undecorate = function($table) {
    if (!($table.parent('.simditor-table').length > 0)) {
      return;
    }
    return $table.parent().replaceWith($table);
  };

  TableButton.prototype.renderMenu = function() {
    var $table;
    $("<div class=\"menu-create-table\">\n</div>\n<div class=\"menu-edit-table\">\n  <ul>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"deleteRow\">\n        <span>" + (this._t('deleteRow')) + "</span>\n      </a>\n    </li>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"insertRowAbove\">\n        <span>" + (this._t('insertRowAbove')) + " ( Ctrl + Alt + ↑ )</span>\n      </a>\n    </li>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"insertRowBelow\">\n        <span>" + (this._t('insertRowBelow')) + " ( Ctrl + Alt + ↓ )</span>\n      </a>\n    </li>\n    <li><span class=\"separator\"></span></li>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"deleteCol\">\n        <span>" + (this._t('deleteColumn')) + "</span>\n      </a>\n    </li>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"insertColLeft\">\n        <span>" + (this._t('insertColumnLeft')) + " ( Ctrl + Alt + ← )</span>\n      </a>\n    </li>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"insertColRight\">\n        <span>" + (this._t('insertColumnRight')) + " ( Ctrl + Alt + → )</span>\n      </a>\n    </li>\n    <li><span class=\"separator\"></span></li>\n    <li>\n      <a tabindex=\"-1\" unselectable=\"on\" class=\"menu-item\"\n        href=\"javascript:;\" data-param=\"deleteTable\">\n        <span>" + (this._t('deleteTable')) + "</span>\n      </a>\n    </li>\n  </ul>\n</div>").appendTo(this.menuWrapper);
    this.createMenu = this.menuWrapper.find('.menu-create-table');
    this.editMenu = this.menuWrapper.find('.menu-edit-table');
    $table = this.createTable(6, 6).appendTo(this.createMenu);
    this.createMenu.on('mouseenter', 'td, th', (function(_this) {
      return function(e) {
        var $td, $tr, $trs, num;
        _this.createMenu.find('td, th').removeClass('selected');
        $td = $(e.currentTarget);
        $tr = $td.parent();
        num = $tr.find('td, th').index($td) + 1;
        $trs = $tr.prevAll('tr').addBack();
        if ($tr.parent().is('tbody')) {
          $trs = $trs.add($table.find('thead tr'));
        }
        return $trs.find("td:lt(" + num + "), th:lt(" + num + ")").addClass('selected');
      };
    })(this));
    this.createMenu.on('mouseleave', function(e) {
      return $(e.currentTarget).find('td, th').removeClass('selected');
    });
    return this.createMenu.on('mousedown', 'td, th', (function(_this) {
      return function(e) {
        var $closestBlock, $td, $tr, colNum, rowNum;
        _this.wrapper.removeClass('menu-on');
        if (!_this.editor.inputManager.focused) {
          return;
        }
        $td = $(e.currentTarget);
        $tr = $td.parent();
        colNum = $tr.find('td').index($td) + 1;
        rowNum = $tr.prevAll('tr').length + 1;
        if ($tr.parent().is('tbody')) {
          rowNum += 1;
        }
        $table = _this.createTable(rowNum, colNum, true);
        $closestBlock = _this.editor.selection.blockNodes().last();
        if (_this.editor.util.isEmptyNode($closestBlock)) {
          $closestBlock.replaceWith($table);
        } else {
          $closestBlock.after($table);
        }
        _this.decorate($table);
        _this.editor.selection.setRangeAtStartOf($table.find('th:first'));
        _this.editor.trigger('valuechanged');
        return false;
      };
    })(this));
  };

  TableButton.prototype.createTable = function(row, col, phBr) {
    var $table, $tbody, $td, $thead, $tr, c, k, l, r, ref, ref1;
    $table = $('<table/>');
    $thead = $('<thead/>').appendTo($table);
    $tbody = $('<tbody/>').appendTo($table);
    for (r = k = 0, ref = row; 0 <= ref ? k < ref : k > ref; r = 0 <= ref ? ++k : --k) {
      $tr = $('<tr/>');
      $tr.appendTo(r === 0 ? $thead : $tbody);
      for (c = l = 0, ref1 = col; 0 <= ref1 ? l < ref1 : l > ref1; c = 0 <= ref1 ? ++l : --l) {
        $td = $(r === 0 ? '<th/>' : '<td/>').appendTo($tr);
        if (phBr) {
          $td.append(this.editor.util.phBr);
        }
      }
    }
    return $table;
  };

  TableButton.prototype.refreshTableWidth = function($table) {
    return setTimeout((function(_this) {
      return function() {
        var cols, tableWidth;
        tableWidth = $table.width();
        cols = $table.find('col');
        return $table.find('thead tr th').each(function(i, td) {
          var $col;
          $col = cols.eq(i);
          return $col.attr('width', ($(td).outerWidth() / tableWidth * 100) + '%');
        });
      };
    })(this), 0);
  };

  TableButton.prototype.setActive = function(active) {
    TableButton.__super__.setActive.call(this, active);
    if (active) {
      this.createMenu.hide();
      return this.editMenu.show();
    } else {
      this.createMenu.show();
      return this.editMenu.hide();
    }
  };

  TableButton.prototype._changeCellTag = function($tr, tagName) {
    return $tr.find('td, th').each(function(i, cell) {
      var $cell;
      $cell = $(cell);
      return $cell.replaceWith("<" + tagName + ">" + ($cell.html()) + "</" + tagName + ">");
    });
  };

  TableButton.prototype.deleteRow = function($td) {
    var $newTr, $tr, index;
    $tr = $td.parent('tr');
    if ($tr.closest('table').find('tr').length < 1) {
      return this.deleteTable($td);
    } else {
      $newTr = this._nextRow($tr);
      if (!($newTr.length > 0)) {
        $newTr = this._prevRow($tr);
      }
      index = $tr.find('td, th').index($td);
      if ($tr.parent().is('thead')) {
        $newTr.appendTo($tr.parent());
        this._changeCellTag($newTr, 'th');
      }
      $tr.remove();
      return this.editor.selection.setRangeAtEndOf($newTr.find('td, th').eq(index));
    }
  };

  TableButton.prototype.insertRow = function($td, direction) {
    var $newTr, $table, $tr, cellTag, colNum, i, index, k, ref;
    if (direction == null) {
      direction = 'after';
    }
    $tr = $td.parent('tr');
    $table = $tr.closest('table');
    colNum = 0;
    $table.find('tr').each(function(i, tr) {
      return colNum = Math.max(colNum, $(tr).find('td').length);
    });
    index = $tr.find('td, th').index($td);
    $newTr = $('<tr/>');
    cellTag = 'td';
    if (direction === 'after' && $tr.parent().is('thead')) {
      $tr.parent().next('tbody').prepend($newTr);
    } else if (direction === 'before' && $tr.parent().is('thead')) {
      $tr.before($newTr);
      $tr.parent().next('tbody').prepend($tr);
      this._changeCellTag($tr, 'td');
      cellTag = 'th';
    } else {
      $tr[direction]($newTr);
    }
    for (i = k = 1, ref = colNum; 1 <= ref ? k <= ref : k >= ref; i = 1 <= ref ? ++k : --k) {
      $("<" + cellTag + "/>").append(this.editor.util.phBr).appendTo($newTr);
    }
    return this.editor.selection.setRangeAtStartOf($newTr.find('td, th').eq(index));
  };

  TableButton.prototype.deleteCol = function($td) {
    var $newTd, $table, $tr, index, noOtherCol, noOtherRow;
    $tr = $td.parent('tr');
    noOtherRow = $tr.closest('table').find('tr').length < 2;
    noOtherCol = $td.siblings('td, th').length < 1;
    if (noOtherRow && noOtherCol) {
      return this.deleteTable($td);
    } else {
      index = $tr.find('td, th').index($td);
      $newTd = $td.next('td, th');
      if (!($newTd.length > 0)) {
        $newTd = $tr.prev('td, th');
      }
      $table = $tr.closest('table');
      $table.find('col').eq(index).remove();
      $table.find('tr').each(function(i, tr) {
        return $(tr).find('td, th').eq(index).remove();
      });
      this.refreshTableWidth($table);
      return this.editor.selection.setRangeAtEndOf($newTd);
    }
  };

  TableButton.prototype.insertCol = function($td, direction) {
    var $col, $newCol, $newTd, $table, $tr, index, tableWidth, width;
    if (direction == null) {
      direction = 'after';
    }
    $tr = $td.parent('tr');
    index = $tr.find('td, th').index($td);
    $table = $td.closest('table');
    $col = $table.find('col').eq(index);
    $table.find('tr').each((function(_this) {
      return function(i, tr) {
        var $newTd, cellTag;
        cellTag = $(tr).parent().is('thead') ? 'th' : 'td';
        $newTd = $("<" + cellTag + "/>").append(_this.editor.util.phBr);
        return $(tr).find('td, th').eq(index)[direction]($newTd);
      };
    })(this));
    $newCol = $('<col/>');
    $col[direction]($newCol);
    tableWidth = $table.width();
    width = Math.max(parseFloat($col.attr('width')) / 2, 50 / tableWidth * 100);
    $col.attr('width', width + '%');
    $newCol.attr('width', width + '%');
    this.refreshTableWidth($table);
    $newTd = direction === 'after' ? $td.next('td, th') : $td.prev('td, th');
    return this.editor.selection.setRangeAtStartOf($newTd);
  };

  TableButton.prototype.deleteTable = function($td) {
    var $block, $table;
    $table = $td.closest('.simditor-table');
    $block = $table.next('p');
    $table.remove();
    if ($block.length > 0) {
      return this.editor.selection.setRangeAtStartOf($block);
    }
  };

  TableButton.prototype.command = function(param) {
    var $td;
    $td = this.editor.selection.containerNode().closest('td, th');
    if (!($td.length > 0)) {
      return;
    }
    if (param === 'deleteRow') {
      this.deleteRow($td);
    } else if (param === 'insertRowAbove') {
      this.insertRow($td, 'before');
    } else if (param === 'insertRowBelow') {
      this.insertRow($td);
    } else if (param === 'deleteCol') {
      this.deleteCol($td);
    } else if (param === 'insertColLeft') {
      this.insertCol($td, 'before');
    } else if (param === 'insertColRight') {
      this.insertCol($td);
    } else if (param === 'deleteTable') {
      this.deleteTable($td);
    } else {
      return;
    }
    return this.editor.trigger('valuechanged');
  };

  return TableButton;

})(Button);

Simditor.Toolbar.addButton(TableButton);

StrikethroughButton = (function(superClass) {
  extend(StrikethroughButton, superClass);

  function StrikethroughButton() {
    return StrikethroughButton.__super__.constructor.apply(this, arguments);
  }

  StrikethroughButton.prototype.name = 'strikethrough';

  StrikethroughButton.prototype.icon = 'strikethrough';

  StrikethroughButton.prototype.htmlTag = 'strike';

  StrikethroughButton.prototype.disableTag = 'pre';

  StrikethroughButton.prototype._activeStatus = function() {
    var active;
    active = document.queryCommandState('strikethrough') === true;
    this.setActive(active);
    return this.active;
  };

  StrikethroughButton.prototype.command = function() {
    document.execCommand('strikethrough');
    if (!this.editor.util.support.oninput) {
      this.editor.trigger('valuechanged');
    }
    return $(document).trigger('selectionchange');
  };

  return StrikethroughButton;

})(Button);

Simditor.Toolbar.addButton(StrikethroughButton);

AlignmentButton = (function(superClass) {
  extend(AlignmentButton, superClass);

  function AlignmentButton() {
    return AlignmentButton.__super__.constructor.apply(this, arguments);
  }

  AlignmentButton.prototype.name = "alignment";

  AlignmentButton.prototype.icon = 'align-left';

  AlignmentButton.prototype.htmlTag = 'p, h1, h2, h3, h4, td, th';

  AlignmentButton.prototype._init = function() {
    this.menu = [
      {
        name: 'left',
        text: this._t('alignLeft'),
        icon: 'align-left',
        param: 'left'
      }, {
        name: 'center',
        text: this._t('alignCenter'),
        icon: 'align-center',
        param: 'center'
      }, {
        name: 'right',
        text: this._t('alignRight'),
        icon: 'align-right',
        param: 'right'
      }
    ];
    return AlignmentButton.__super__._init.call(this);
  };

  AlignmentButton.prototype.setActive = function(active, align) {
    if (align == null) {
      align = 'left';
    }
    if (align !== 'left' && align !== 'center' && align !== 'right') {
      align = 'left';
    }
    if (align === 'left') {
      AlignmentButton.__super__.setActive.call(this, false);
    } else {
      AlignmentButton.__super__.setActive.call(this, active);
    }
    this.el.removeClass('align-left align-center align-right');
    if (active) {
      this.el.addClass('align-' + align);
    }
    this.setIcon('align-' + align);
    return this.menuEl.find('.menu-item').show().end().find('.menu-item-' + align).hide();
  };

  AlignmentButton.prototype._status = function() {
    this.nodes = this.editor.selection.nodes().filter(this.htmlTag);
    if (this.nodes.length < 1) {
      this.setDisabled(true);
      return this.setActive(false);
    } else {
      this.setDisabled(false);
      return this.setActive(true, this.nodes.first().css('text-align'));
    }
  };

  AlignmentButton.prototype.command = function(align) {
    if (align !== 'left' && align !== 'center' && align !== 'right') {
      throw new Error("simditor alignment button: invalid align " + align);
    }
    this.nodes.css({
      'text-align': align === 'left' ? '' : align
    });
    this.editor.trigger('valuechanged');
    return this.editor.inputManager.throttledSelectionChanged();
  };

  return AlignmentButton;

})(Button);

Simditor.Toolbar.addButton(AlignmentButton);

return Simditor;

}));
