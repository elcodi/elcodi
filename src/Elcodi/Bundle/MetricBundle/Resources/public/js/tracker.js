/**
 * _etc can be anything or an array
 * at this point, if it is an array, we can collect all data inserted previously
 * and perform given track actions once the object is created
 *
 * _etc.push(['3267462837', 'product_add'])
 * _etc.push(['3267462837', 'product_add', {'user'= '12267'}])
 */
var _etc = (function (ts) {

    function push(t) {
        var token = t[0],
            event = t[1],
            id = t[2],
            type = t[3],
            lastChild = document.body.lastChild,
            element = document.createElement('img');

        element.src = '/api/_m/'.concat(token, '/', event, '.png?i=', id, '&t=', type, '&r=', 1 * new Date);
        element.height = 1;
        element.width = 1;
        element.style.display = 'none';
        lastChild.parentNode.insertBefore(element, lastChild);
    }

    for (var idx = 0; idx < ts.length; ++idx) {
        push(_etc[idx]);
    }

    return {
        push: push,
    };

}(_etc || []));
