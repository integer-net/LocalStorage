(function(window, cookies) {

    /**
     * http://stackoverflow.com/questions/30106476/using-javascripts-atob-to-decode-base64-doesnt-properly-decode-utf-8-strings
     *
     * @param str
     * @returns {string}
     */
    var b64_to_utf8 = function(str) {
        return decodeURIComponent(escape(window.atob( str )));
    }

    window.IntegernetLocalstorage = Class.create();
    /**
     * Callbacks can be registered statically before initialization
     *
     * @type Function[]
     */
    window.IntegernetLocalstorage.callbacks = [];
    window.IntegernetLocalstorage.prototype = {
        localStorage: null,
        prefix: 'integernet_',
        initialize: function() {
            this.updatedKeys = {};
            if (this.isAvailable()) {
                this.localStorage = window.localStorage;
            } else {
                this.localStorage = {
                    'key': function() {},
                    'getItem': function() { return "null" },
                    'setItem': function() {},
                    'removeItem': function() {},
                    'clear': function() {}
                }
            }
        },
        isAvailable: function() {
            return typeof window.localStorage != 'undefined';
        },
        get: function(key) {
            key = this.prefix + key;
            return JSON.parse(this.localStorage.getItem(key));

        },
        set: function(key, value) {
            this.updatedKeys[key] = true;
            key = this.prefix + key;
            this.localStorage.setItem(key, JSON.stringify(value));
        },
        hasChanged: function(key) {
            console.log(this.updatedKeys);
            console.log(this.updatedKeys[key]);
            return typeof this.updatedKeys[key] != 'undefined';
        },
        /**
         * Save HTML from given elements to local storage. The elements need a data attribute like
         *
         *    data-integernet_localstorage_key="..."
         *
         * @param elements Array of DOM elements
         */
        saveElements: function(elements) {
            for (var i=0; i < elements.length; ++i) {
                var key, value;
                if (elements[i].dataset.integernet_localstorage_key) {
                    key = elements[i].dataset.integernet_localstorage_key;
                } else if (elements[i].getAttribute('data-integernet_localstorage_key')) {
                    key = elements[i].getAttribute('data-integernet_localstorage_key');
                } else {
                    continue;
                }
                value = elements[i].innerHTML;
                this.set(key, value);
            }
        },
        /**
         * Save values from cookie to local storage and deletes the cookie afterwards.
         * The cookie must be "integernet_localstorage" and contain JSON in the form:
         *
         *  [
         *    { "key" : "...", "value": "..." },
         *    { "key" : "...", "value": "..." },
         *    ...
         *  ]
         *
         *  where the values are base64 encoded strings.
         */
        moveFromCookie: function() {
            var cookieJson = cookies.get('integernet_localstorage');
            if (cookieJson) {
                var cookieData = JSON.parse(cookieJson);
                for (var i=0; i < cookieData.length; ++i) {
                    this.set(cookieData[i].key, b64_to_utf8(cookieData[i].value));
                }
            }
            cookies.clear('integernet_localstorage');
        },
        callCallbacks: function() {
            var storage = this;
            var call = function(fn) {
                fn(storage);
            };
            window.IntegernetLocalstorage.callbacks.forEach(call);
        }
    };
})(window, Mage.Cookies);
