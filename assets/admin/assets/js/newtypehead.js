!function (t, e) {
	"use strict";
	"undefined" != typeof module && module.exports ? module.exports = e(require("jquery")) : "function" == typeof define && define.amd ? define(["jquery"], function (t) {
		return e(t)
	}) : e(t.jQuery)
}(this, function (t) {
	"use strict";
	var e = function (s, i) {
		this.$element = t(s), this.options = t.extend({}, e.defaults, i), this.matcher = this.options.matcher || this.matcher, this.sorter = this.options.sorter || this.sorter, this.select = this.options.select || this.select, this.autoSelect = "boolean" != typeof this.options.autoSelect || this.options.autoSelect, this.highlighter = this.options.highlighter || this.highlighter, this.render = this.options.render || this.render, this.updater = this.options.updater || this.updater, this.displayText = this.options.displayText || this.displayText, this.itemLink = this.options.itemLink || this.itemLink, this.itemTitle = this.options.itemTitle || this.itemTitle, this.followLinkOnSelect = this.options.followLinkOnSelect || this.followLinkOnSelect, this.source = this.options.source, this.delay = this.options.delay, this.theme = this.options.theme && this.options.themes && this.options.themes[this.options.theme] || e.defaults.themes[e.defaults.theme], this.$menu = t(this.options.menu || this.theme.menu), this.$appendTo = this.options.appendTo ? t(this.options.appendTo) : null, this.fitToElement = "boolean" == typeof this.options.fitToElement && this.options.fitToElement, this.shown = !1, this.listen(), this.showHintOnFocus = ("boolean" == typeof this.options.showHintOnFocus || "all" === this.options.showHintOnFocus) && this.options.showHintOnFocus, this.afterSelect = this.options.afterSelect, this.afterEmptySelect = this.options.afterEmptySelect, this.addItem = !1, this.value = this.$element.val() || this.$element.text(), this.keyPressed = !1, this.focused = this.$element.is(":focus"), this.changeInputOnSelect = this.options.changeInputOnSelect || this.changeInputOnSelect, this.changeInputOnMove = this.options.changeInputOnMove || this.changeInputOnMove, this.openLinkInNewTab = this.options.openLinkInNewTab || this.openLinkInNewTab, this.selectOnBlur = this.options.selectOnBlur || this.selectOnBlur, this.showCategoryHeader = this.options.showCategoryHeader || this.showCategoryHeader
	};
	e.prototype = {
		constructor: e, setDefault: function (t) {
			if (this.$element.data("active", t), this.autoSelect || t) {
				var e = this.updater(t);
				e || (e = ""), this.$element.val(this.displayText(e) || e).text(this.displayText(e) || e).change(), this.afterSelect(e)
			}
			return this.hide()
		}, select: function () {
			var t = this.$menu.find(".active").data("value");
			if (this.$element.data("active", t), this.autoSelect || t) {
				var e = this.updater(t);
				e || (e = ""), this.changeInputOnSelect && this.$element.val(this.displayText(e) || e).text(this.displayText(e) || e).change(), this.followLinkOnSelect && this.itemLink(t) ? (this.openLinkInNewTab ? window.open(this.itemLink(t), "_blank") : document.location = this.itemLink(t), this.afterSelect(e)) : this.followLinkOnSelect && !this.itemLink(t) ? this.afterEmptySelect(e) : this.afterSelect(e)
			} else this.afterEmptySelect();
			return this.hide()
		}, updater: function (t) {
			return t
		}, setSource: function (t) {
			this.source = t
		}, show: function () {
			var e, s = t.extend({}, this.$element.position(), {height: this.$element[0].offsetHeight}),
				i = "function" == typeof this.options.scrollHeight ? this.options.scrollHeight.call() : this.options.scrollHeight;
			if (this.shown ? e = this.$menu : this.$appendTo ? (e = this.$menu.appendTo(this.$appendTo), this.hasSameParent = this.$appendTo.is(this.$element.parent())) : (e = this.$menu.insertAfter(this.$element), this.hasSameParent = !0), !this.hasSameParent) {
				e.css("position", "fixed");
				var o = this.$element.offset();
				s.top = o.top, s.left = o.left
			}
			var n = t(e).parent().hasClass("dropup") ? "auto" : s.top + s.height + i,
				h = t(e).hasClass("dropdown-menu-right") ? "auto" : s.left;
			return e.css({
				top: n,
				left: h
			}).show(), !0 === this.options.fitToElement && e.css("width", this.$element.outerWidth() + "px"), this.shown = !0, this
		}, hide: function () {
			return this.$menu.hide(), this.shown = !1, this
		}, lookup: function (e) {
			if (this.query = null != e ? e : this.$element.val(), this.query.length < this.options.minLength && !this.options.showHintOnFocus) return this.shown ? this.hide() : this;
			var s = t.proxy(function () {
				t.isFunction(this.source) && 3 === this.source.length ? this.source(this.query, t.proxy(this.process, this), t.proxy(this.process, this)) : t.isFunction(this.source) ? this.source(this.query, t.proxy(this.process, this)) : this.source && this.process(this.source)
			}, this);
			clearTimeout(this.lookupWorker), this.lookupWorker = setTimeout(s, this.delay)
		}, process: function (e) {
			var s = this;
			return e = t.grep(e, function (t) {
				return s.matcher(t)
			}), (e = this.sorter(e)).length || this.options.addItem ? (e.length > 0 ? this.$element.data("active", e[0]) : this.$element.data("active", null), "all" != this.options.items && (e = e.slice(0, this.options.items)), this.options.addItem && e.push(this.options.addItem), this.render(e).show()) : this.shown ? this.hide() : this
		}, matcher: function (t) {
			return ~this.displayText(t).toLowerCase().indexOf(this.query.toLowerCase())
		}, sorter: function (t) {
			for (var e, s = [], i = [], o = []; e = t.shift();) {
				var n = this.displayText(e);
				n.toLowerCase().indexOf(this.query.toLowerCase()) ? ~n.indexOf(this.query) ? i.push(e) : o.push(e) : s.push(e)
			}
			return s.concat(i, o)
		}, highlighter: function (t) {
			var e = this.query;
			if ("" === e) return t;
			var s, i = t.match(/(>)([^<]*)(<)/g), o = [], n = [];
			if (i && i.length) for (s = 0; s < i.length; ++s) i[s].length > 2 && o.push(i[s]); else (o = []).push(t);
			e = e.replace(/[\(\)\/\.\*\+\?\[\]]/g, function (t) {
				return "\\" + t
			});
			var h, a = new RegExp(e, "g");
			for (s = 0; s < o.length; ++s) (h = o[s].match(a)) && h.length > 0 && n.push(o[s]);
			for (s = 0; s < n.length; ++s) t = t.replace(n[s], n[s].replace(a, "<strong>$&</strong>"));
			return t
		}, render: function (e) {
			var s = this, i = this, o = !1, n = [], h = s.options.separator;
			return t.each(e, function (t, s) {
				t > 0 && s[h] !== e[t - 1][h] && n.push({__type: "divider"}), this.showCategoryHeader && (!s[h] || 0 !== t && s[h] === e[t - 1][h] || n.push({
					__type: "category",
					name: s[h]
				})), n.push(s)
			}), e = t(n).map(function (e, n) {
				if ("category" == (n.__type || !1)) return t(s.options.headerHtml || s.theme.headerHtml).text(n.name)[0];
				if ("divider" == (n.__type || !1)) return t(s.options.headerDivider || s.theme.headerDivider)[0];
				var h = i.displayText(n);
				return (e = t(s.options.item || s.theme.item).data("value", n)).find(s.options.itemContentSelector || s.theme.itemContentSelector).addBack(s.options.itemContentSelector || s.theme.itemContentSelector).html(s.highlighter(h, n)), s.options.followLinkOnSelect && e.find("a").attr("href", i.itemLink(n)), e.find("a").attr("title", i.itemTitle(n)), h == i.$element.val() && (e.addClass("active"), i.$element.data("active", n), o = !0), e[0]
			}), this.autoSelect && !o && (e.filter(":not(.dropdown-header)").first().addClass("active"), this.$element.data("active", e.first().data("value"))), this.$menu.html(e), this
		}, displayText: function (t) {
			return void 0 !== t && void 0 !== t.name ? t.name : t
		}, itemLink: function (t) {
			return null
		}, itemTitle: function (t) {
			return null
		}, next: function (e) {
			var s = this.$menu.find(".active").removeClass("active").next();
			for (s.length || (s = t(this.$menu.find(t(this.options.item || this.theme.item).prop("tagName"))[0])); s.hasClass("divider") || s.hasClass("dropdown-header");) s = s.next();
			s.addClass("active");
			var i = this.updater(s.data("value"));
			this.changeInputOnMove && this.$element.val(this.displayText(i) || i)
		}, prev: function (e) {
			var s = this.$menu.find(".active").removeClass("active").prev();
			for (s.length || (s = this.$menu.find(t(this.options.item || this.theme.item).prop("tagName")).last()); s.hasClass("divider") || s.hasClass("dropdown-header");) s = s.prev();
			s.addClass("active");
			var i = this.updater(s.data("value"));
			this.changeInputOnMove && this.$element.val(this.displayText(i) || i)
		}, listen: function () {
			this.$element.on("focus.bootstrap3Typeahead", t.proxy(this.focus, this)).on("blur.bootstrap3Typeahead", t.proxy(this.blur, this)).on("keypress.bootstrap3Typeahead", t.proxy(this.keypress, this)).on("propertychange.bootstrap3Typeahead input.bootstrap3Typeahead", t.proxy(this.input, this)).on("keyup.bootstrap3Typeahead", t.proxy(this.keyup, this)), this.eventSupported("keydown") && this.$element.on("keydown.bootstrap3Typeahead", t.proxy(this.keydown, this));
			var e = t(this.options.item || this.theme.item).prop("tagName");
			"ontouchstart" in document.documentElement ? this.$menu.on("touchstart", e, t.proxy(this.touchstart, this)).on("touchend", e, t.proxy(this.click, this)) : this.$menu.on("click", t.proxy(this.click, this)).on("mouseenter", e, t.proxy(this.mouseenter, this)).on("mouseleave", e, t.proxy(this.mouseleave, this)).on("mousedown", t.proxy(this.mousedown, this))
		}, destroy: function () {
			this.$element.data("typeahead", null), this.$element.data("active", null), this.$element.unbind("focus.bootstrap3Typeahead").unbind("blur.bootstrap3Typeahead").unbind("keypress.bootstrap3Typeahead").unbind("propertychange.bootstrap3Typeahead input.bootstrap3Typeahead").unbind("keyup.bootstrap3Typeahead"), this.eventSupported("keydown") && this.$element.unbind("keydown.bootstrap3-typeahead"), this.$menu.remove(), this.destroyed = !0
		}, eventSupported: function (t) {
			var e = t in this.$element;
			return e || (this.$element.setAttribute(t, "return;"), e = "function" == typeof this.$element[t]), e
		}, move: function (t) {
			if (this.shown) switch (t.keyCode) {
				case 9:
				case 13:
				case 27:
					t.preventDefault();
					break;
				case 38:
					if (t.shiftKey) return;
					t.preventDefault(), this.prev();
					break;
				case 40:
					if (t.shiftKey) return;
					t.preventDefault(), this.next()
			}
		}, keydown: function (e) {
			17 !== e.keyCode && (this.keyPressed = !0, this.suppressKeyPressRepeat = ~t.inArray(e.keyCode, [40, 38, 9, 13, 27]), this.shown || 40 != e.keyCode ? this.move(e) : this.lookup())
		}, keypress: function (t) {
			this.suppressKeyPressRepeat || this.move(t)
		}, input: function (t) {
			var e = this.$element.val() || this.$element.text();
			this.value !== e && (this.value = e, this.lookup())
		}, keyup: function (t) {
			if (!this.destroyed) switch (t.keyCode) {
				case 40:
				case 38:
				case 16:
				case 17:
				case 18:
					break;
				case 9:
					if (!this.shown || this.showHintOnFocus && !this.keyPressed) return;
					this.select();
					break;
				case 13:
					if (!this.shown) return;
					this.select();
					break;
				case 27:
					if (!this.shown) return;
					this.hide()
			}
		}, focus: function (t) {
			this.focused || (this.focused = !0, this.keyPressed = !1, this.options.showHintOnFocus && !0 !== this.skipShowHintOnFocus && ("all" === this.options.showHintOnFocus ? this.lookup("") : this.lookup())), this.skipShowHintOnFocus && (this.skipShowHintOnFocus = !1)
		}, blur: function (t) {
			this.mousedover || this.mouseddown || !this.shown ? this.mouseddown && (this.skipShowHintOnFocus = !0, this.$element.focus(), this.mouseddown = !1) : (this.selectOnBlur && this.select(), this.hide(), this.focused = !1, this.keyPressed = !1)
		}, click: function (t) {
			t.preventDefault(), this.skipShowHintOnFocus = !0, this.select(), this.$element.focus(), this.hide()
		}, mouseenter: function (e) {
			this.mousedover = !0, this.$menu.find(".active").removeClass("active"), t(e.currentTarget).addClass("active")
		}, mouseleave: function (t) {
			this.mousedover = !1, !this.focused && this.shown && this.hide()
		}, mousedown: function (t) {
			this.mouseddown = !0, this.$menu.one("mouseup", function (t) {
				this.mouseddown = !1
			}.bind(this))
		}, touchstart: function (e) {
			e.preventDefault(), this.$menu.find(".active").removeClass("active"), t(e.currentTarget).addClass("active")
		}, touchend: function (t) {
			t.preventDefault(), this.select(), this.$element.focus()
		}
	};
	var s = t.fn.typeahead;
	t.fn.typeahead = function (s) {
		var i = arguments;
		return "string" == typeof s && "getActive" == s ? this.data("active") : this.each(function () {
			var o = t(this), n = o.data("typeahead"), h = "object" == typeof s && s;
			n || o.data("typeahead", n = new e(this, h)), "string" == typeof s && n[s] && (i.length > 1 ? n[s].apply(n, Array.prototype.slice.call(i, 1)) : n[s]())
		})
	}, e.defaults = {
		source: [],
		items: 8,
		minLength: 1,
		scrollHeight: 0,
		autoSelect: !0,
		afterSelect: t.noop,
		afterEmptySelect: t.noop,
		addItem: !1,
		followLinkOnSelect: !1,
		delay: 0,
		separator: "category",
		changeInputOnSelect: !0,
		changeInputOnMove: !0,
		openLinkInNewTab: !1,
		selectOnBlur: !0,
		showCategoryHeader: !0,
		theme: "bootstrap3",
		themes: {
			bootstrap3: {
				menu: '<ul class="typeahead dropdown-menu" role="listbox"></ul>',
				item: '<li><a class="dropdown-item" href="#" role="option"></a></li>',
				itemContentSelector: "a",
				headerHtml: '<li class="dropdown-header"></li>',
				headerDivider: '<li class="divider" role="separator"></li>'
			},
			bootstrap4: {
				menu: '<div class="typeahead dropdown-menu" role="listbox"></div>',
				item: '<button class="dropdown-item" role="option"></button>',
				itemContentSelector: ".dropdown-item",
				headerHtml: '<h6 class="dropdown-header"></h6>',
				headerDivider: '<div class="dropdown-divider"></div>'
			}
		}
	}, t.fn.typeahead.Constructor = e, t.fn.typeahead.noConflict = function () {
		return t.fn.typeahead = s, this
	}, t(document).on("focus.typeahead.data-api", '[data-provide="typeahead"]', function (e) {
		var s = t(this);
		s.data("typeahead") || s.typeahead(s.data())
	})
});


function addchildoption(id = '') {
	var count = $(".itemRow").length;
	var count_mc = $(".itemMenu").length;
	count++;
	var htmlRows = '';
	htmlRows += '<tr>';
	htmlRows += '<td><input type="checkbox" class="form-control itemRow" id="option_ck_' + count + '"></td>';
	htmlRows += '<td><input type="text" class="form-control" id="question_option_' + count + '" name="question_option[' + id + '][]"></td>';
	htmlRows += '<td><input type="text" class="form-control" id="option_coin_' + count + '" name="option_coin[' + id + '][]"></td>';
	htmlRows += '<td><input type="text" class="form-control" id="multi_option_coin_' + count + '" name="multi_option_coin[' + id + '][]"></td>';
	htmlRows += '<td><input type="number" class="form-control" id="option_serial_' + count + '" name="option_serial[' + id + '][]" ></td>';
	htmlRows += '</tr>';
	$('.option_menu_' + id).append(htmlRows);
}

function removeChildOption(id = '') {
	$(document).on('click', '.removeOption_' + id + '', function () {
		$(".itemRow:checked").each(function () {
			$(this).closest('tr').remove();
		});
	});
}

var count_m = $(".itemMenu").length;
$(document).on('click', '.addOptionMenu', function () {
	count_m++;
	var htmlRows = '<table class="option_menu_' + count_m + '">\n' +
		'\t\t\t\t\t\t\t<thead>\n' +
		'\t\t\t\t\t\t\t<tr>\n' +
		'\t\t\t\t\t\t\t\t<th colspan="4" style="text-align: center">Question Form ' + count_m + '</th>\n' +
		'\t\t\t\t\t\t\t</tr>\n' +
		'\t\t\t\t\t\t\t<tr>\n' +
		'\t\t\t\t\t\t\t\t<th><input type="checkbox" class="itemMenu" id="question_ck_' + count_m + '" name="question_ck"></th>\n' +
		'\t\t\t\t\t\t\t\t<th colspan="2"><input type="text" class="form-control" id="question_' + count_m + '" name="question[' + count_m + ']" placeholder="type question here"></th>\n' +
		'\t\t\t\t\t\t\t\t<th><input type="number" class="form-control" id="question_serial_' + count_m + '" name="question_serial[' + count_m + ']"></th>\n' +
		'\t\t\t\t\t\t\t\t<th><button type="button" value="' + count_m + '" class="btn btn-success addNewOption_' + count_m + '" onclick="return addchildoption(this.value);">+</button>&nbsp;<button type="button" value="' + count_m + '" class="btn btn-danger removeOption_' + count_m + '" onclick="return removeChildOption(this.value);">-</button></th>\n' +
		'\t\t\t\t\t\t\t</tr>\n' +
		'\t\t\t\t\t\t\t<tr>\n' +
		'\t\t\t\t\t\t\t\t<th>#</th>\n' +
		'\t\t\t\t\t\t\t\t<th>Option</th>\n' +
		'\t\t\t\t\t\t\t\t<th>Coin</th>\n' +
		'\t\t\t\t\t\t\t\t<th>Serial</th>\n' +
		'\t\t\t\t\t\t\t</tr>\n' +
		'\t\t\t\t\t\t\t</thead>\n' +
		'\t\t\t\t\t\t\t<tbody>\n' +
		'\t\t\t\t\t\t\t<tr>\n' +
		'\t\t\t\t\t\t\t\t<td><input type="checkbox" class="form-control itemRow" id="option_ck_' + count_m + '"></td>\n' +
		'\t\t\t\t\t\t\t\t<td><input type="text" class="form-control"  id="question_option_' + count_m + '" name="question_option[' + count_m + '][]"></td>\n' +
		'\t\t\t\t\t\t\t\t<td><input type="text" class="form-control" id="option_coin_' + count_m + '" name="option_coin[' + count_m + '][]"></td>\n' +
		'\t\t\t\t\t\t\t\t<td><input type="text" class="form-control" id="multi_option_coin_' + count_m + '" name="multi_option_coin[' + count_m + '][]"></td>\n' +
		'\t\t\t\t\t\t\t\t<td><input type="number" class="form-control" id="option_serial_' + count_m + '" name="option_serial[' + count_m + '][]"></td>\n' +
		'\t\t\t\t\t\t\t</tr>\n' +
		'\t\t\t\t\t\t\t</tbody>\n' +
		'\t\t\t\t\t\t</table><br>';
	$('#add_new_option').append(htmlRows);
});

$(document).on('click', '.removeOptionMenu', function () {
	$(".itemMenu:checked").each(function () {
		$(this).closest('table').remove();
	});
});
