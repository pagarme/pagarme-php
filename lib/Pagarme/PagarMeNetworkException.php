<?php

class PagarMeNetworkException extends RuntimeException
{

    const CODE_UNSUPPORTED_PROTOCOL     = 1;
    const CODE_FAILED_INIT              = 2;
    const CODE_URL_MALFORMAT            = 3;
    const CODE_NOT_BUILT_IN             = 4;
    const CODE_COULDNT_RESOLVE_PROXY    = 5;
    const CODE_COULDNT_RESOLVE_HOST     = 6;
    const CODE_COULDNT_CONNECT          = 7;
    const CODE_FTP_WEIRD_SERVER_REPLY   = 8;
    const CODE_REMOTE_ACCESS_DENIED     = 9;
    const CODE_FTP_ACCEPT_FAILED        = 10;
    const CODE_FTP_WEIRD_PASS_REPLY     = 11;
    const CODE_FTP_ACCEPT_TIMEOUT       = 12;
    const CODE_FTP_WEIRD_PASV_REPLY     = 13;
    const CODE_FTP_WEIRD_227_FORMAT     = 14;
    const CODE_FTP_CANT_GET_HOST        = 15;
    const CODE_HTTP2                    = 16;
    const CODE_FTP_COULDNT_SET_TYPE     = 17;
    const CODE_PARTIAL_FILE             = 18;
    const CODE_FTP_COULDNT_RETR_FILE    = 19;
    const CODE_QUOTE_ERROR              = 21;
    const CODE_HTTP_RETURNED_ERROR      = 22;
    const CODE_WRITE_ERROR              = 23;
    const CODE_UPLOAD_FAILED            = 25;
    const CODE_READ_ERROR               = 26;
    const CODE_OUT_OF_MEMORY            = 27;
    const CODE_OPERATION_TIMEDOUT       = 28;
    const CODE_FTP_PORT_FAILED          = 30;
    const CODE_FTP_COULDNT_USE_REST     = 31;
    const CODE_RANGE_ERROR              = 33;
    const CODE_HTTP_POST_ERROR          = 34;
    const CODE_SSL_CONNECT_ERROR        = 35;
    const CODE_BAD_DOWNLOAD_RESUME      = 36;
    const CODE_FILE_COULDNT_READ_FILE   = 37;
    const CODE_LDAP_CANNOT_BIND         = 38;
    const CODE_LDAP_SEARCH_FAILED       = 39;
    const CODE_FUNCTION_NOT_FOUND       = 41;
    const CODE_ABORTED_BY_CALLBACK      = 42;
    const CODE_BAD_FUNCTION_ARGUMENT    = 43;
    const CODE_INTERFACE_FAILED         = 45;
    const CODE_TOO_MANY_REDIRECTS       = 47;
    const CODE_UNKNOWN_OPTION           = 48;
    const CODE_TELNET_OPTION_SYNTAX     = 49;
    const CODE_PEER_FAILED_VERIFICATION = 51;
    const CODE_GOT_NOTHING              = 52;
    const CODE_SSL_ENGINE_NOTFOUND      = 53;
    const CODE_SSL_ENGINE_SETFAILED     = 54;
    const CODE_SEND_ERROR               = 55;
    const CODE_RECV_ERROR               = 56;
    const CODE_SSL_CERTPROBLEM          = 58;
    const CODE_SSL_CIPHER               = 59;
    const CODE_SSL_CACERT               = 60;
    const CODE_BAD_CONTENT_ENCODING     = 61;
    const CODE_LDAP_INVALID_URL         = 62;
    const CODE_FILESIZE_EXCEEDED        = 63;
    const CODE_USE_SSL_FAILED           = 64;
    const CODE_SEND_FAIL_REWIND         = 65;
    const CODE_SSL_ENGINE_INITFAILED    = 66;
    const CODE_LOGIN_DENIED             = 67;
    const CODE_TFTP_NOTFOUND            = 68;
    const CODE_TFTP_PERM                = 69;
    const CODE_REMOTE_DISK_FULL         = 70;
    const CODE_TFTP_ILLEGAL             = 71;
    const CODE_TFTP_UNKNOWNID           = 72;
    const CODE_REMOTE_FILE_EXISTS       = 73;
    const CODE_TFTP_NOSUCHUSER          = 74;
    const CODE_CONV_FAILED              = 75;
    const CODE_CONV_REQD                = 76;
    const CODE_SSL_CACERT_BADFILE       = 77;
    const CODE_REMOTE_FILE_NOT_FOUND    = 78;
    const CODE_SSH                      = 79;
    const CODE_SSL_SHUTDOWN_FAILED      = 80;
    const CODE_AGAIN                    = 81;
    const CODE_SSL_CRL_BADFILE          = 82;
    const CODE_SSL_ISSUER_ERROR         = 83;
    const CODE_FTP_PRET_FAILED          = 84;
    const CODE_RTSP_CSEQ_ERROR          = 85;
    const CODE_RTSP_SESSION_ERROR       = 86;
    const CODE_FTP_BAD_FILE_LIST        = 87;
    const CODE_CHUNK_FAILED             = 88;
    const CODE_NO_CONNECTION_AVAILABLE  = 89;
    const CODE_SSL_PINNEDPUBKEYNOTMATCH = 90;
    const CODE_SSL_INVALIDCERTSTATUS    = 91;


    private $messages = [
        self::CODE_UNSUPPORTED_PROTOCOL     => 'Libcurl does not support that protocol',
        self::CODE_FAILED_INIT              => 'Libcurl initialization code failed',
        self::CODE_URL_MALFORMAT            => 'The URL was not properly formatted',
        self::CODE_NOT_BUILT_IN             => 'A requested feature, protocol or option was not found built-in in this libcurl due to a build-time decision',
        self::CODE_COULDNT_RESOLVE_PROXY    => 'Couldn\'t resolve proxy',
        self::CODE_COULDNT_RESOLVE_HOST     => 'Couldn\'t resolve host',
        self::CODE_COULDNT_CONNECT          => 'Failed to connect to host or proxy',
        self::CODE_FTP_WEIRD_SERVER_REPLY   => 'Libcurl got a strange or bad reply',
        self::CODE_REMOTE_ACCESS_DENIED     => 'Access denied to the resource given in the URL',
        self::CODE_FTP_ACCEPT_FAILED        => 'FTP accept has failed',
        self::CODE_FTP_WEIRD_PASS_REPLY     => 'An unexpected FTP code was returned',
        self::CODE_FTP_ACCEPT_TIMEOUT       => 'Timeout has expired',
        self::CODE_FTP_WEIRD_PASV_REPLY     => 'Libcurl got a strange or bad reply',
        self::CODE_FTP_WEIRD_227_FORMAT     => 'Libcurl fail to parse',
        self::CODE_FTP_CANT_GET_HOST        => 'Libcurl can\'t get the host',
        self::CODE_HTTP2                    => 'A problem was detected in the HTTP2 framing layer',
        self::CODE_FTP_COULDNT_SET_TYPE     => 'Received an error when trying to set the transfer mode to binary or ASCII',
        self::CODE_PARTIAL_FILE             => 'A file transfer was shorter or larger than expected',
        self::CODE_FTP_COULDNT_RETR_FILE    => 'Weird reply to a \'RETR\' command or a zero byte transfer complete',
        self::CODE_QUOTE_ERROR              => 'One of the commands returned an error code that is 400 or higher or otherwise indicated unsuccessful completion of the command',
        self::CODE_HTTP_RETURNED_ERROR      => 'HTTP server returns an error code that is 400 or higher',
        self::CODE_WRITE_ERROR              => 'An error occurred when writing received data to a local file, or an error was returned to libcurl from a write callback',
        self::CODE_UPLOAD_FAILED            => 'Failed starting the upload',
        self::CODE_READ_ERROR               => 'There was a problem reading a local file or an error returned by the read callback',
        self::CODE_OUT_OF_MEMORY            => 'A memory allocation request failed',
        self::CODE_OPERATION_TIMEDOUT       => 'Operation timeout',
        self::CODE_FTP_PORT_FAILED          => 'The FTP PORT command returned a error',
        self::CODE_FTP_COULDNT_USE_REST     => 'The FTP REST command returned a error',
        self::CODE_RANGE_ERROR              => 'The server does not support or accept range requests',
        self::CODE_HTTP_POST_ERROR          => 'Libcurl returned a HTTP post error',
        self::CODE_SSL_CONNECT_ERROR        => 'A problem occurred somewhere in the SSL/TLS handshake',
        self::CODE_BAD_DOWNLOAD_RESUME      => 'The download could not be resumed because the specified offset was out of the file boundary',
        self::CODE_FILE_COULDNT_READ_FILE   => 'A file given with FILE:// couldn\'t be opened.',
        self::CODE_LDAP_CANNOT_BIND         => 'LDAP bind operation failed',
        self::CODE_LDAP_SEARCH_FAILED       => 'LDAP search failed',
        self::CODE_FUNCTION_NOT_FOUND       => 'A required zlib function was not found',
        self::CODE_ABORTED_BY_CALLBACK      => 'Aborted by callback',
        self::CODE_BAD_FUNCTION_ARGUMENT    => 'A function was called with a bad parameter',
        self::CODE_INTERFACE_FAILED         => 'A specified outgoing interface could not be used',
        self::CODE_TOO_MANY_REDIRECTS       => 'Too many redirects',
        self::CODE_UNKNOWN_OPTION           => 'An option passed to libcurl is not recognized/known',
        self::CODE_TELNET_OPTION_SYNTAX     => 'A telnet option string was Illegally formatted',
        self::CODE_PEER_FAILED_VERIFICATION => 'The remote server\'s SSL certificate or SSH md5 fingerprint was deemed not OK',
        self::CODE_GOT_NOTHING              => 'Nothing was returned from the server',
        self::CODE_SSL_ENGINE_NOTFOUND      => 'The specified crypto engine wasn\'t found',
        self::CODE_SSL_ENGINE_SETFAILED     => 'Failed setting the selected SSL crypto engine as default',
        self::CODE_SEND_ERROR               => 'Failed sending network data',
        self::CODE_RECV_ERROR               => 'Failure with receiving network data',
        self::CODE_SSL_CERTPROBLEM          => 'Problem with the local client certificate',
        self::CODE_SSL_CIPHER               => 'Can\'t use specified cipher',
        self::CODE_SSL_CACERT               => 'Peer certificate cannot be authenticated with known CA certificates',
        self::CODE_BAD_CONTENT_ENCODING     => 'Unrecognized transfer encoding',
        self::CODE_LDAP_INVALID_URL         => 'Invalid LDAP URL',
        self::CODE_FILESIZE_EXCEEDED        => 'Maximum file size exceeded',
        self::CODE_USE_SSL_FAILED           => 'Requested FTP SSL level failed',
        self::CODE_SEND_FAIL_REWIND         => 'Fail sending rewind',
        self::CODE_SSL_ENGINE_INITFAILED    => 'Initiating the SSL Engine failed',
        self::CODE_LOGIN_DENIED             => 'The remote server denied curl to login',
        self::CODE_TFTP_NOTFOUND            => 'File not found on TFTP server',
        self::CODE_TFTP_PERM                => 'Permission problem on TFTP server',
        self::CODE_REMOTE_DISK_FULL         => 'Out of disk space on the server',
        self::CODE_TFTP_ILLEGAL             => 'Illegal TFTP operation',
        self::CODE_TFTP_UNKNOWNID           => 'Unknown TFTP transfer ID',
        self::CODE_REMOTE_FILE_EXISTS       => 'File already exists and will not be overwritten',
        self::CODE_TFTP_NOSUCHUSER          => 'There\'s no such user on TFTP',
        self::CODE_CONV_FAILED              => 'Character conversion failed',
        self::CODE_CONV_REQD                => 'Caller must register conversion callbacks',
        self::CODE_SSL_CACERT_BADFILE       => 'Problem with reading the SSL CA cert',
        self::CODE_REMOTE_FILE_NOT_FOUND    => 'The resource referenced in the URL does not exist',
        self::CODE_SSH                      => 'An unspecified error occurred during the SSH session',
        self::CODE_SSL_SHUTDOWN_FAILED      => 'Failed to shut down the SSL connection',
        self::CODE_AGAIN                    => 'Socket is not ready for send/recv wait till it\'s ready and try again',
        self::CODE_SSL_CRL_BADFILE          => 'Failed to load CRL file',
        self::CODE_SSL_ISSUER_ERROR         => 'Issuer check failed',
        self::CODE_FTP_PRET_FAILED          => 'The FTP server does not understand the PRET command at all or does not support the given CODE_BAD_FUNCTION_ARGUMENT',
        self::CODE_RTSP_CSEQ_ERROR          => 'Mismatch of RTSP CSeq numbers',
        self::CODE_RTSP_SESSION_ERROR       => 'Mismatch of RTSP Session Identifiers',
        self::CODE_FTP_BAD_FILE_LIST        => 'Unable to parse FTP file list',
        self::CODE_CHUNK_FAILED             => 'Chunk callback reported error',
        self::CODE_NO_CONNECTION_AVAILABLE  => 'No connection available, the session will be queued',
        self::CODE_SSL_PINNEDPUBKEYNOTMATCH => 'Failed to match the pinned key',
        self::CODE_SSL_INVALIDCERTSTATUS    => 'Status returned failure',
    ];

    public function __construct($code)
    {
        parent::__construct(
            isset($this->messages[$code]) ? $this->messages[$code] : 'Unknow Error',
            $code
        );
    }

}