window.sessionStorage.clear();
QUnit.module("Features");
QUnit.test("Instantiation", function(assert) {
    assert.ok(window.IntegernetLocalstorage instanceof Function, "window.IntegernetLocalstorage exists!" );
    var storage = new window.IntegernetLocalstorage();
    assert.ok(storage.isAvailable(), "isAvailable() returns true");
});
QUnit.test("Read and Write", function(assert) {
    var storage = new window.IntegernetLocalstorage();
    storage.set('some-key', 'Some string');
    assert.equal(storage.get('some-key'), 'Some string', "get() and set() work with string values");

    var complexData = [ { 'foo': 'bar'}, null, [], 0.42];
    storage.set('other-key', complexData);
    assert.propEqual(storage.get('other-key'), complexData, "get() and set() work with complex data");
});
QUnit.test("Save from HTML", function(assert) {
    var storage = new window.IntegernetLocalstorage();
    storage.saveElements($$('.integernet-localstorage-html'));
    assert.equal(storage.get('cart'), $('cart').innerHTML, 'HTML saved in local storage');
    assert.equal(storage.get('cart'), $('cart').innerHTML, 'HTML saved in local storage');
});
QUnit.test("Save from Cookie", function(assert) {
    var storage = new window.IntegernetLocalstorage();
    var expectedHtml = '<div id="cart">Updated Shopping Cart (möp)</div>';
    Mage.Cookies.set("integernet_localstorage","[{\"key\":\"cart\",\"value\":\"PGRpdiBpZD0iY2FydCI+VXBkYXRlZCBTaG9wcGluZyBDYXJ0IChtw7ZwKTwvZGl2Pg==\"}]");
    storage.moveFromCookie();
    assert.equal(storage.get('cart'), expectedHtml, "base64 decoded cookie value should be saved")
    assert.equal(document.cookie.indexOf('integernet_localstorage'), -1, 'Cookie deleted after saving');

});
QUnit.test("Save from split Cookies", function(assert) {
    var storage = new window.IntegernetLocalstorage();
    var expectedHtml = '<div id="cart">Updated Shopping Cart (möp)</div>';
    Mage.Cookies.set("integernet_localstorage","[{\"key\":\"cart\",\"value\":\"PGRpdiBpZD0iY2FydCI+VXBkYXRlZCBTaG9wcGluZyBD");
    Mage.Cookies.set("integernet_localstorage.1", "YXJ0IChtw7ZwKTwvZGl2Pg==\"}]");
    storage.moveFromCookie();
    assert.equal(storage.get('cart'), expectedHtml, "base64 decoded cookie value should be saved")
    assert.equal(document.cookie.indexOf('integernet_localstorage'), -1, 'Cookie deleted after saving');
});
QUnit.test("Detect new values", function(assert) {
    var storage = new window.IntegernetLocalstorage();
    storage.set('something new', 'yay!');
    assert.notOk(storage.hasChanged('nonexistent'), 'hasChanged() is false for nonexistent key');
    assert.ok(storage.hasChanged('something new'), 'hasChanged() is true for new value');

    storage = new window.IntegernetLocalstorage();
    assert.notOk(storage.hasChanged('something new'), 'hasChanged() is false for unchanged value');
    storage.set('something new', 'updated!');
    assert.ok(storage.hasChanged('something new'), 'hasChanged() is true for changed value');
});
QUnit.test("Call callbacks", function(assert) {
    window.IntegernetLocalstorage.callbacks.push(function(storage) {
        assert.equal(storage.get('something for the callback'), 'how are you?', 'Callback should be able to access storage');
        storage.set('something from the callback', 'thanks, good');
    });

    var storage = new window.IntegernetLocalstorage();
    storage.set('something for the callback', 'how are you?')
    storage.callCallbacks();
    assert.equal(storage.get('something from the callback'), 'thanks, good', 'Callback should be called and modified storage');

    window.IntegernetLocalstorage.callbacks = [];
});

QUnit.module("Error handling");
//TODO possible fallback: use the cookie and don't dismiss it
QUnit.test("Graceful Degradation", function(assert) {
    var _localStorage = window.sessionStorage;
    delete window.sessionStorage;

    var storage = new window.IntegernetLocalstorage();
    assert.ok(typeof window.sessionStorage == 'undefined', 'Emulate shitty browser.');
    assert.notOk(storage.isAvailable(), "isAvailable() returns false.");
    storage.set('some-key', 'Some string');
    assert.ok(storage.get('some-key') == null, 'get() and set() do nothing if local storage not available.');

    window.sessionStorage = _localStorage;
});