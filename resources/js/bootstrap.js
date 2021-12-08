window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// Add JWT token to headers requests
axios.interceptors.request.use(
    config => {
        config.headers.Accept = 'application/json'

        let token = document.cookie.split(';').find(index => {
            return index.includes('token=')
        })
        token = 'Bearer ' + token.split('=')[1]
        config.headers.Authorization = token

        return config
    },
    error => {
        return error
    }
)

// Refresh JWT token
axios.interceptors.response.use(
    config => {
        return config
    },
    error => {
        if (error.response.status == 401) {
            axios.post('http://127.0.0.1:8000/api/auth/refresh')
                .then(response => {
                    document.cookie = 'token=' + response.data.token
                    console.log('Token atualizado: ', response.data.token)
                    window.location.reload()
                })
        }
        return Promise.reject(error)
    }
)