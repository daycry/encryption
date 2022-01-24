var Encryption = (function($) {
    'use strict';
    var __instance = null;
    var __key = null;
    var __encryptMethod = 'AES-256-CBC';
    var __iv = CryptoJS.lib.WordArray.random(16);
    var __salt = CryptoJS.lib.WordArray.random(256);
    var __iterations = 999;

    var __cryptoJSAesJson = {
        stringify: function (cipherParams) {
            var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
            if (cipherParams.iv) j.iv = cipherParams.iv.toString();
            if (cipherParams.salt) j.s = cipherParams.salt.toString();
            if (cipherParams.key) j.k = cipherParams.key.toString();
            return JSON.stringify(j);
        },
        parse: function (jsonStr) {
            var j = JSON.parse(jsonStr);
            var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
            if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv);
            if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s);
            if (j.k) cipherParams.key = CryptoJS.enc.Hex.parse(j.k);

            return cipherParams;
        }
    };

    var init = function() {
        return {
            setKey: setKey,
            encrypt: encrypt,
            decrypt: decrypt
        };
    };

    var encryptMethodLength = function() {
        var encryptMethod = __encryptMethod;
        var aesNumber = encryptMethod.match(/\d+/)[0];

        return parseInt(aesNumber);
    };

    var encryptKeySize = function() {
        var aesNumber = encryptMethodLength();
        return parseInt(aesNumber / 8);
    };

    var setKey = function( key ) {
        __key = key;
    }

    var randomString = function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;

        for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }

    var encrypt = function( data )
    {
        if( __key === null )
        {
            __key = randomString(10);
        }
        var length = ( encryptMethodLength() / 4 );
        var hashKey = CryptoJS.PBKDF2( __key, __salt, {'hasher': CryptoJS.algo.SHA512, 'keySize': ( length / 8), 'iterations': __iterations } );

        var encrypted = CryptoJS.AES.encrypt(data, hashKey, { 'format': __cryptoJSAesJson, 'mode': CryptoJS.mode.CBC, 'iv': __iv, 'salt': __salt } );
        
        var output = {
            'ct': CryptoJS.enc.Base64.stringify(encrypted.ciphertext),
            'iv': CryptoJS.enc.Hex.stringify(__iv),
            's': CryptoJS.enc.Hex.stringify(__salt),
            'iterations': __iterations,
            'k': CryptoJS.enc.Hex.stringify( CryptoJS.enc.Utf8.parse(__key) )
        };

        return JSON.stringify(output);
        //return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(JSON.stringify(output)));
    };

    var decrypt = function( data, key )
    {
        key = (typeof key !== 'undefined') ?  key : __key;

        data = JSON.parse(data);
        //data = JSON.parse(CryptoJS.enc.Utf8.stringify(CryptoJS.enc.Base64.parse(data)));

        var salt = CryptoJS.enc.Hex.parse(data.s);
        var iv = CryptoJS.enc.Hex.parse(data.iv);
        var encrypted = data.ct;

        if( data.k )
        {
            key = CryptoJS.enc.Hex.parse(data.k);
        }

        var iterations = parseInt(data.iterations);
        if (iterations <= 0) { iterations = 999; }

        var length = ( encryptMethodLength() / 4);
        var hashKey = CryptoJS.PBKDF2( key, salt, {'hasher': CryptoJS.algo.SHA512, 'keySize': (length / 8), 'iterations': iterations});

        var decrypted = CryptoJS.AES.decrypt(encrypted, hashKey, {'mode': CryptoJS.mode.CBC, 'iv': iv});

        return decrypted.toString(CryptoJS.enc.Utf8);
    };

    return {
        // Get the Singleton instance if one exists
        // or create one if it doesn't
        getInstance: function()
        {
            if ( !__instance )
            {
                __instance = init();
            }

            return __instance;
        }
    };
})(jQuery);