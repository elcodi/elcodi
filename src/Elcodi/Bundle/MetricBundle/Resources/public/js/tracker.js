/**
 * _etc can be anything or an array
 * at this point, if it is an array, we can collect all data inserted previously
 * and perform given track actions once the object is created
 *
 * _etc.push(['3267462837', 'product_add'])
 * _etc.push(['3267462837', 'product_add', {'user'= '12267'}])
 */
var _etcref = _etc || [];
var _etc = (function () {

    var _etcbackup = _etcref.slice(0);
    var _etc = {
        push: function (element) {
            var token = element[0];
            var event = element[1];
            var id = element[2];
            var type = element[3];

            var _etcr = document.createElement('img');
            _etcr.src = '/_m/' + token + '/' + event + '.png';
            _etcr.src += '?i=' + id;
            _etcr.src += '&t=' + type;
            _etcr.src += '&_r=' + Math.random().toString(36);
            _etcr.height = "1";
            _etcr.width = "1";

            this.appendTracker(_etcr);
        },
        appendTracker: function (_tracker) {
            var _body = document.getElementsByTagName('body')[0];
            var _bodylastchild = _body.lastChild;
            _bodylastchild.parentNode.insertBefore(_tracker, _bodylastchild.nextSibling);
        }
    };

    while (_etcbackup.length > 0) {
        _etc.push(_etcbackup.shift());
    }

    return _etc;
}());