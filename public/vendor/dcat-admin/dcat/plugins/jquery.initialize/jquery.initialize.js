/*!
 * https://github.com/adampietrasiak/jquery.initialize
 *
 * Copyright (c) 2015-2016 Adam Pietrasiak
 * Released under the MIT license
 * https://github.com/timpler/jquery.initialize/blob/master/LICENSE
 *
 * This is based on MutationObserver
 * https://developer.mozilla.org/en-US/docs/Web/API/MutationObserver
 */
;(function ($) {

    "use strict";

    var combinators = [' ', '>', '+', '~']; // https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors#Combinators
    var fraternisers = ['+', '~']; // These combinators involve siblings.
    var complexTypes = ['ATTR', 'PSEUDO', 'ID', 'CLASS']; // These selectors are based upon attributes.

    //Check if browser supports "matches" function
    if (!Element.prototype.matches) {
        Element.prototype.matches = Element.prototype.matchesSelector ||
            Element.prototype.webkitMatchesSelector ||
            Element.prototype.mozMatchesSelector ||
            Element.prototype.msMatchesSelector;
    }

    // Understand what kind of selector the initializer is based upon.
    function grok(msobserver) {
        if (!$.find.tokenize) {
            // This is an old version of jQuery, so cannot parse the selector.
            // Therefore we must assume the worst case scenario. That is, that
            // this is a complicated selector. This feature was available in:
            // https://github.com/jquery/sizzle/issues/242
            msobserver.isCombinatorial = true;
            msobserver.isFraternal = true;
            msobserver.isComplex = true;
            return;
        }

        // Parse the selector.
        msobserver.isCombinatorial = false;
        msobserver.isFraternal = false;
        msobserver.isComplex = false;
        var token = $.find.tokenize(msobserver.selector);
        for (var i = 0; i < token.length; i++) {
            for (var j = 0; j < token[i].length; j++) {
                if (combinators.indexOf(token[i][j].type) != -1)
                    msobserver.isCombinatorial = true; // This selector uses combinators.

                if (fraternisers.indexOf(token[i][j].type) != -1)
                    msobserver.isFraternal = true; // This selector uses sibling combinators.

                if (complexTypes.indexOf(token[i][j].type) != -1)
                    msobserver.isComplex = true; // This selector is based on attributes.
            }
        }
    }

    // MutationSelectorObserver represents a selector and it's associated initialization callback.
    var MutationSelectorObserver = function (selector, callback, options) {
        this.selector = selector.trim();
        this.callback = callback;
        this.options = options;

        grok(this);
    };

    // List of MutationSelectorObservers.
    var msobservers = [];
    msobservers.initialize = function (selector, callback, options) {

        // Wrap the callback so that we can ensure that it is only
        // called once per element.
        var seen = [];
        var callbackOnce = function () {
            if (seen.indexOf(this) == -1) {
                seen.push(this);
                $(this).each(callback);
            }
        };

        // See if the selector matches any elements already on the page.
        $(options.target).find(selector).each(callbackOnce);

        // Then, add it to the list of selector observers.
        var msobserver = new MutationSelectorObserver(selector, callbackOnce, options)
        this.push(msobserver);

        // The MutationObserver watches for when new elements are added to the DOM.
        var observer = new MutationObserver(function (mutations) {
            var matches = [];

            // For each mutation.
            for (var m = 0; m < mutations.length; m++) {

                // If this is an attributes mutation, then the target is the node upon which the mutation occurred.
                if (mutations[m].type == 'attributes') {
                    // Check if the mutated node matchs.
                    if (mutations[m].target.matches(msobserver.selector))
                        matches.push(mutations[m].target);

                    // If the selector is fraternal, query siblings of the mutated node for matches.
                    if (msobserver.isFraternal)
                        matches.push.apply(matches, mutations[m].target.parentElement.querySelectorAll(msobserver.selector));
                    else
                        matches.push.apply(matches, mutations[m].target.querySelectorAll(msobserver.selector));
                }

                // If this is an childList mutation, then inspect added nodes.
                if (mutations[m].type == 'childList') {
                    // Search added nodes for matching selectors.
                    for (var n = 0; n < mutations[m].addedNodes.length; n++) {
                        if (!(mutations[m].addedNodes[n] instanceof Element)) continue;

                        // Check if the added node matches the selector
                        if (mutations[m].addedNodes[n].matches(msobserver.selector))
                            matches.push(mutations[m].addedNodes[n]);

                        // If the selector is fraternal, query siblings for matches.
                        if (msobserver.isFraternal)
                            matches.push.apply(matches, mutations[m].addedNodes[n].parentElement.querySelectorAll(msobserver.selector));
                        else
                            matches.push.apply(matches, mutations[m].addedNodes[n].querySelectorAll(msobserver.selector));
                    }
                }
            }

            // For each match, call the callback using jQuery.each() to initialize the element (once only.)
            for (var i = 0; i < matches.length; i++) {
                $(matches[i]).each(msobserver.callback);
            }
        });

        // Observe the target element.
        var defaultObeserverOpts = { childList: true, subtree: true, attributes: msobserver.isComplex };
        observer.observe(options.target, options.observer || defaultObeserverOpts );

        return observer;
    };

    // Deprecated API (does not work with jQuery >= 3.1.1):
    $.fn.initialize = function (callback, options) {
        return msobservers.initialize(this.selector, callback, $.extend({}, $.initialize.defaults, options));
    };

    // Supported API
    $.initialize = function (selector, callback, options) {
        return msobservers.initialize(selector, callback, $.extend({}, $.initialize.defaults, options));
    };

    // Options
    $.initialize.defaults = {
        target: document.documentElement, // Defaults to observe the entire document.
        observer: null // MutationObserverInit: Defaults to internal configuration if not provided.
    }

})(jQuery);