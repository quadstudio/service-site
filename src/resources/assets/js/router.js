let routes = require('./routes.json');

let route = function() {
    let args = Array.prototype.slice.call(arguments);
    let name = args.shift();

    if (routes[name] === undefined) {
        console.error('Unknown route ', name);
    } else {
        return '/' + routes[name]
                .split('/')
                .map(s => s[0] === '{' ? args.shift() : s)
                .join('/');
    }
};

export default route;