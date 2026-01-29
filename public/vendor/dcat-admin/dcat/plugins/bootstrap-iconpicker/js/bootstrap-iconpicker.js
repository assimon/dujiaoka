/*!========================================================================
* File: bootstrap-iconpicker.js v1.10.0 by @victor-valencia
* https://victor-valencia.github.com/bootstrap-iconpicker
* ========================================================================
* Copyright 2013-2018 Victor Valencia Rico.
* Licensed under MIT license.
* https://github.com/victor-valencia/bootstrap-iconpicker/blob/master/LICENSE
* ========================================================================
*/

;(function($){ "use strict";

    // ICONPICKER PUBLIC CLASS DEFINITION
    // ==============================
    var Iconpicker = function (element, options) {

      if (typeof $.fn.popover === 'undefined' || typeof $.fn.popover.Constructor.VERSION === 'undefined') {
        throw new TypeError('Bootstrap iconpicker require Bootstrap popover');
      }

      this.$element = $(element);
      this.options  = $.extend({}, Iconpicker.DEFAULTS, this.$element.data());
      this.options  = $.extend({}, this.options, options);

    };

    // ICONPICKER VERSION
    // ==============================
    Iconpicker.VERSION = '1.10.0';

    // ICONPICKER ICONSET_EMPTY
    // ==============================
    Iconpicker.ICONSET_EMPTY = {
        iconClass: '',
        iconClassFix: '',
        icons: []
    };

    // ICONPICKER ICONSET
    // ==============================
    Iconpicker.ICONSET = {
        _custom: null,
        elusiveicon: $.iconset_elusiveicon || Iconpicker.ICONSET_EMPTY,
        flagicon: $.iconset_flagicon || Iconpicker.ICONSET_EMPTY,
        fontawesome4: $.iconset_fontawesome_4 || Iconpicker.ICONSET_EMPTY,
        fontawesome5: $.iconset_fontawesome_5 || Iconpicker.ICONSET_EMPTY,
        glyphicon: $.iconset_glyphicon || Iconpicker.ICONSET_EMPTY,
        ionicon: $.iconset_ionicon || Iconpicker.ICONSET_EMPTY,
        mapicon: $.iconset_mapicon || Iconpicker.ICONSET_EMPTY,
        materialdesign: $.iconset_materialdesign || Iconpicker.ICONSET_EMPTY,
        octicon: $.iconset_octicon || Iconpicker.ICONSET_EMPTY,
        typicon: $.iconset_typicon || Iconpicker.ICONSET_EMPTY,
        weathericon: $.iconset_weathericon || Iconpicker.ICONSET_EMPTY
    };

    // ICONPICKER DEFAULTS
    // ==============================
    Iconpicker.DEFAULTS = {
        align: 'center',
        arrowClass: 'btn-primary',
        arrowNextIconClass: 'fas fa-arrow-right',
        arrowPrevIconClass: 'fas fa-arrow-left',
        cols: 4,
        icon: '',
        iconset: 'fontawesome5',
        iconsetVersion: 'lastest',
        header: true,
        labelHeader: '{0} / {1}',
        footer: true,
        labelFooter: '{0} - {1} of {2}',
        placement: 'bottom',
        rows: 4,
        search: true,
        searchText: 'Search icon',
        selectedClass: 'btn-warning',
        unselectedClass: 'btn-secondary'
    };

    // ICONPICKER PRIVATE METHODS
    // ==============================
    Iconpicker.prototype.bindEvents = function () {
        var op = this.options;
        var el = this;
        op.table.find('.btn-previous, .btn-next').off('click').on('click', function(e) {
            e.preventDefault();
            if(!$(this).hasClass('disabled')){
                var inc = parseInt($(this).val(), 10);
                el.changeList(op.page + inc);
            }
        });
        op.table.find('.btn-icon').off('click').on('click', function(e) {
            e.preventDefault();
            el.select($(this).val());
            if(op.inline === false){
                el.$element.popover(($.fn.bsVersion() === '3.x') ? 'destroy' : 'dispose');
            }
            else{
                op.table.find("i[class$='" + $(this).val() + "']").parent().addClass(op.selectedClass);
            }
        });
        op.table.find('.search-control').off('keyup').on('keyup', function() {
            el.changeList(1);
        });
    };

    Iconpicker.prototype.changeList = function (page) {
        this.filterIcons();
        this.updateLabels(page);
        this.updateIcons(page);
        this.options.page = page;
        this.bindEvents();
    };

    Iconpicker.prototype.filterIcons = function () {
        var op = this.options;
        var search = op.table.find('.search-control').val();
        var icons = [];
        if(op.iconsetVersion != 'lastest' && typeof Iconpicker.ICONSET[op.iconset].allVersions != 'undefined'){
            $.each(Iconpicker.ICONSET[op.iconset].allVersions, function(i, v){
                if(op.iconsetVersion == v.version){
                    icons = v.icons;
                }
            });
        }
        else
            icons = Iconpicker.ICONSET[op.iconset].icons;

        if (search === "") {
            op.icons = icons;
        }
        else {
            var result = [];
            $.each(icons, function(i, v) {
               if (v.toLowerCase().indexOf(search) > -1) {
                   result.push(v);
               }
            });
            op.icons = result;
        }
    };

    Iconpicker.prototype.removeAddClass = function (target, remove, add) {
        this.options.table.find(target).removeClass(remove).addClass(add);
        return add;
    };

    Iconpicker.prototype.reset = function () {
        this.updatePicker();
        this.changeList(1);
    };

    Iconpicker.prototype.select = function (icon) {
        var op = this.options;
        var el = this.$element;
        op.selected = $.inArray(icon.replace(op.iconClassFix, ''), op.icons);
        if (op.selected === -1) {
            op.selected = 0;
            icon = op.iconClassFix + op.icons[op.selected];
        }
        if (icon !== '' && op.selected >= 0) {
            op.icon = icon;
            if(op.inline === false){
                el.find('input').val(icon);
                el.find('i').attr('class', '').addClass(op.iconClass).addClass(icon);
            }
            if(icon === op.iconClassFix){
                el.trigger({ type: "change", icon: 'empty' });
            }
            else {
                el.trigger({ type: "change", icon: icon });
                el.find('input').val(icon);
            }
            op.table.find('button.' + op.selectedClass).removeClass(op.selectedClass);
        }
    };

    Iconpicker.prototype.switchPage = function (icon) {
        var op = this.options;
        op.selected = $.inArray(icon.replace(op.iconClassFix, ''), op.icons);

        if(op.selected >= 0) {
            var page = Math.ceil((op.selected + 1) / this.totalIconsPerPage());
            this.changeList(page);
        }
        if(icon === ''){
            //if(op.iconClassFix !== '')
                op.table.find('i.' + op.iconClassFix).parent().addClass(op.selectedClass);
            //else
        }
        else{
            op.table.find('i.' + icon).parent().addClass(op.selectedClass);
        }
    };

    Iconpicker.prototype.totalPages = function () {
        return Math.ceil(this.totalIcons() / this.totalIconsPerPage());
    };

    Iconpicker.prototype.totalIcons = function () {
        return this.options.icons.length;
    };

    Iconpicker.prototype.totalIconsPerPage = function () {
        if(this.options.rows === 0){
            return this.options.icons.length;
        }
        else{
            return this.options.cols * this.options.rows;
        }
    };

    Iconpicker.prototype.updateArrows = function (page) {
        var op = this.options;
        var total_pages = this.totalPages();
        if (page === 1) {
            op.table.find('.btn-previous').addClass('disabled');
        }
        else {
            op.table.find('.btn-previous').removeClass('disabled');
        }
        if (page === total_pages || total_pages === 0) {
            op.table.find('.btn-next').addClass('disabled');
        }
        else {
            op.table.find('.btn-next').removeClass('disabled');
        }
    };

    Iconpicker.prototype.updateIcons = function (page) {
        var op = this.options;
        var tbody = op.table.find('tbody').empty();
        var offset = (page - 1) * this.totalIconsPerPage();
        var length = op.rows;
        if(op.rows === 0){
            length = op.icons.length;
        }
        for (var i = 0; i < length; i++) {
            var tr = $('<tr></tr>');
            for (var j = 0; j < op.cols; j++) {
                var pos = offset + (i * op.cols) + j;
                var btn = $('<button class="btn ' + op.unselectedClass + ' btn-icon"></button>').hide();
                if (pos < op.icons.length) {
                    var v = op.iconClassFix + op.icons[pos];
                    btn.val(v).attr('title', v).append('<i class="' + op.iconClass + ' ' + v + '"></i>').show();
                    if (op.icon === v) {
                        btn.addClass(op.selectedClass).addClass('btn-icon-selected');
                    }
                }
                tr.append($('<td></td>').append(btn));
            }
            tbody.append(tr);
        }
    };

    Iconpicker.prototype.updateIconsCount = function () {
        var op = this.options;
        if(op.footer === true){
            var icons_count = [
                '<tr>',
                '   <td colspan="' + op.cols + '" class="text-center">',
                '       <span class="icons-count"></span>',
                '   </td>',
                '</tr>'
            ];
            op.table.find('tfoot').empty().append(icons_count.join(''));
        }
    };

    Iconpicker.prototype.updateLabels = function (page) {
        var op = this.options;
        var total_icons = this.totalIcons();
        var total_pages = this.totalPages();
        op.table.find('.page-count').html(op.labelHeader.replace('{0}', (total_pages === 0 ) ? 0 : page).replace('{1}', total_pages));
        var offset = (page - 1) * this.totalIconsPerPage();
        var total = page * this.totalIconsPerPage();
        op.table.find('.icons-count').html(op.labelFooter.replace('{0}', total_icons ? offset + 1 : 0).replace('{1}', (total < total_icons) ? total: total_icons).replace('{2}', total_icons));
        this.updateArrows(page);
    };

    Iconpicker.prototype.updatePagesCount = function () {
        var op = this.options;
        if(op.header === true){
            var tr = $('<tr></tr>');
            for (var i = 0; i < op.cols; i++) {
                var td = $('<td class="text-center"></td>');
                if (i === 0 || i === op.cols - 1) {
                    var arrow = [
                        '<button class="btn btn-arrow ' + ((i === 0) ? 'btn-previous' : 'btn-next') + ' ' + op.arrowClass + '" value="' + ((i === 0) ? -1 : 1) + '">',
                            '<span class="' + ((i === 0) ? op.arrowPrevIconClass : op.arrowNextIconClass) + '"></span>',
                        '</button>'
                    ];
                    td.append(arrow.join(''));
                    tr.append(td);
                }
                else if (tr.find('.page-count').length === 0) {
                    td.attr('colspan', op.cols - 2).append('<span class="page-count"></span>');
                    tr.append(td);
                }
            }
            op.table.find('thead').empty().append(tr);
        }
    };

    Iconpicker.prototype.updatePicker = function () {
        var op = this.options;
        if (op.cols < 4) {
            throw 'Iconpicker => The number of columns must be greater than or equal to 4. [option.cols = ' + op.cols + ']';
        }
        else if (op.rows < 0) {
            throw 'Iconpicker => The number of rows must be greater than or equal to 0. [option.rows = ' + op.rows + ']';
        }
        else {
            this.updatePagesCount();
            this.updateSearch();
            this.updateIconsCount();
        }
    };

    Iconpicker.prototype.updateSearch = function () {
        var op = this.options;
        var search = [
            '<tr>',
            '   <td colspan="' + op.cols + '">',
            '       <input type="text" class="form-control search-control" style="width: ' + op.cols * (($.fn.bsVersion() === '3.x') ? 39 : 41) + 'px;" placeholder="' + op.searchText + '">',
            '   </td>',
            '</tr>'
        ];
        search = $(search.join(''));
        if (op.search === true) {
            search.show();
        }
        else {
            search.hide();
        }
        op.table.find('thead').append(search);
    };

    // ICONPICKER PUBLIC METHODS
    // ==============================
    Iconpicker.prototype.setAlign = function (value) {
        this.$element.removeClass(this.options.align).addClass(value);
        this.options.align = value;
    };

    Iconpicker.prototype.setArrowClass = function (value) {
        this.options.arrowClass = this.removeAddClass('.btn-arrow', this.options.arrowClass, value);
    };

    Iconpicker.prototype.setArrowNextIconClass = function (value) {
        this.options.arrowNextIconClass = this.removeAddClass('.btn-next > span', this.options.arrowNextIconClass, value);
    };

    Iconpicker.prototype.setArrowPrevIconClass = function (value) {
        this.options.arrowPrevIconClass = this.removeAddClass('.btn-previous > span', this.options.arrowPrevIconClass, value);
    };

    Iconpicker.prototype.setCols = function (value) {
        this.options.cols = value;
        this.reset();
    };

    Iconpicker.prototype.setFooter = function (value) {
        var footer = this.options.table.find('tfoot');
        if (value === true) {
            footer.show();
        }
        else {
            footer.hide();
        }
        this.options.footer = value;
    };

    Iconpicker.prototype.setHeader = function (value) {
        var header = this.options.table.find('thead');
        if (value === true) {
            header.show();
        }
        else {
            header.hide();
        }
        this.options.header = value;
    };

    Iconpicker.prototype.setIcon = function (value) {
        this.select(value);
    };

    Iconpicker.prototype.setIconset = function (value) {
        var op = this.options;
        if ($.isPlainObject(value)) {
            Iconpicker.ICONSET._custom = $.extend(Iconpicker.ICONSET_EMPTY, value);
            op.iconset = '_custom';
        }
        else if (!Iconpicker.ICONSET.hasOwnProperty(value)) {
            op.iconset = Iconpicker.DEFAULTS.iconset;
        }
        else {
            op.iconset = value;
        }
        op = $.extend(op, Iconpicker.ICONSET[op.iconset]);
        this.reset();
        this.select(op.icon);
    };

    Iconpicker.prototype.setLabelHeader = function (value) {
        this.options.labelHeader = value;
        this.updateLabels(this.options.page);
    };

    Iconpicker.prototype.setLabelFooter = function (value) {
        this.options.labelFooter = value;
        this.updateLabels(this.options.page);
    };

    Iconpicker.prototype.setPlacement = function (value) {
        this.options.placement = value;
    };

    Iconpicker.prototype.setRows = function (value) {
        this.options.rows = value;
        this.reset();
    };

    Iconpicker.prototype.setSearch = function (value) {
        var search = this.options.table.find('.search-control');
        if (value === true) {
            search.show();
        }
        else {
            search.hide();
        }
        search.val('');
        this.changeList(1);
        this.options.search = value;
    };

    Iconpicker.prototype.setSearchText = function (value) {
        this.options.table.find('.search-control').attr('placeholder', value);
        this.options.searchText = value;
    };

    Iconpicker.prototype.setSelectedClass = function (value) {
        this.options.selectedClass = this.removeAddClass('.btn-icon-selected', this.options.selectedClass, value);
    };

    Iconpicker.prototype.setUnselectedClass = function (value) {
        this.options.unselectedClass = this.removeAddClass('.btn-icon', this.options.unselectedClass, value);
    };

    // ICONPICKER PLUGIN DEFINITION
    // ========================
    var old = $.fn.iconpicker;
    $.fn.iconpicker = function (option, params) {
        return this.each(function () {
            var $this = $(this);
            var data = $this.data('bs.iconpicker');
            var options = typeof option === 'object' && option;
            if (!data) {
                $this.data('bs.iconpicker', (data = new Iconpicker(this, options)));
            }
            if (typeof option === 'string') {
                if (typeof data[option] === 'undefined') {
                    throw 'Iconpicker => The "' + option + '" method does not exists.';
                }
                else {
                    data[option](params);
                }
            }
            else{
                var op = data.options;
                op = $.extend(op, {
                    inline: false,
                    page: 1,
                    selected: -1,
                    table: $('<table class="table-icons"><thead></thead><tbody></tbody><tfoot></tfoot></table>')
                });
                var name = (typeof $this.attr('name') !== 'undefined') ? 'name="' + $this.attr('name') + '"' : '';

                if($this.prop('tagName') === 'BUTTON'){
                    $this.empty()
                        .append('<i></i>')
                        .append('<input type="hidden" ' + name + '></input>')
                        .append('<span class="caret"></span>')
                        .addClass('iconpicker ' + (($.fn.bsVersion() === '3.x') ? '' : 'dropdown-toggle'));
                    data.setIconset(op.iconset);
                    $this.on('click', function(e) {
                        e.preventDefault();
                        $this.popover({
                            animation: false,
                            trigger: 'manual',
                            html: true,
                            content: op.table,
                            container: 'body',
                            placement: op.placement
                        }).on('inserted.bs.popover', function() {
                            var el = $this.data('bs.popover');
                            var tip = ($.fn.bsVersion() === '3.x') ? el.tip() : $(el.getTipElement())
                            tip.addClass('iconpicker-popover');
                        }).on('shown.bs.popover', function () {
                            data.switchPage(op.icon);
                            data.bindEvents();
                        });
                        //console.log($.fn.bsVersion());
                        $this.popover('show');
                    });
                }
                else{
                    op.inline = true;
                    data.setIconset(op.iconset);
                    $this.empty()
                        .append('<input type="hidden" ' + name + '></input>')
                        .append(op.table)
                        .addClass('iconpicker')
                        .addClass(op.align);
                    data.switchPage(op.icon);
                    data.bindEvents();
                }

            }
        });
    };

    $.fn.iconpicker.Constructor = Iconpicker;

    // ICONPICKER NO CONFLICT
    // ==================
    $.fn.iconpicker.noConflict = function () {
        $.fn.iconpicker = old;
        return this;
    };

    $.fn.bsVersion = function() {
        return $.fn.popover.Constructor.VERSION.substr(0,2) + 'x';
    };

    // ICONPICKER DATA-API
    // ===============
    $(document).on('click', 'body', function (e) {
        $('.iconpicker').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover(($.fn.bsVersion() === '3.x') ? 'destroy' : 'dispose');
            }
        });
    });

    $('button[role="iconpicker"],div[role="iconpicker"]').iconpicker();

})(jQuery);
