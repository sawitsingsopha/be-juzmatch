<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networksecurity/v1beta1/authorization_policy.proto

namespace Google\Cloud\NetworkSecurity\V1beta1\AuthorizationPolicy\Rule\Destination;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specification of HTTP header match atrributes.
 *
 * Generated from protobuf message <code>google.cloud.networksecurity.v1beta1.AuthorizationPolicy.Rule.Destination.HttpHeaderMatch</code>
 */
class HttpHeaderMatch extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the HTTP header to match. For matching
     * against the HTTP request's authority, use a headerMatch
     * with the header name ":authority". For matching a
     * request's method, use the headerName ":method".
     *
     * Generated from protobuf field <code>string header_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $header_name = '';
    protected $type;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $regex_match
     *           Required. The value of the header must match the regular expression
     *           specified in regexMatch. For regular expression grammar,
     *           please see: en.cppreference.com/w/cpp/regex/ecmascript
     *           For matching against a port specified in the HTTP
     *           request, use a headerMatch with headerName set to Host
     *           and a regular expression that satisfies the RFC2616 Host
     *           header's port specifier.
     *     @type string $header_name
     *           Required. The name of the HTTP header to match. For matching
     *           against the HTTP request's authority, use a headerMatch
     *           with the header name ":authority". For matching a
     *           request's method, use the headerName ":method".
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networksecurity\V1Beta1\AuthorizationPolicy::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The value of the header must match the regular expression
     * specified in regexMatch. For regular expression grammar,
     * please see: en.cppreference.com/w/cpp/regex/ecmascript
     * For matching against a port specified in the HTTP
     * request, use a headerMatch with headerName set to Host
     * and a regular expression that satisfies the RFC2616 Host
     * header's port specifier.
     *
     * Generated from protobuf field <code>string regex_match = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getRegexMatch()
    {
        return $this->readOneof(2);
    }

    public function hasRegexMatch()
    {
        return $this->hasOneof(2);
    }

    /**
     * Required. The value of the header must match the regular expression
     * specified in regexMatch. For regular expression grammar,
     * please see: en.cppreference.com/w/cpp/regex/ecmascript
     * For matching against a port specified in the HTTP
     * request, use a headerMatch with headerName set to Host
     * and a regular expression that satisfies the RFC2616 Host
     * header's port specifier.
     *
     * Generated from protobuf field <code>string regex_match = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setRegexMatch($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Required. The name of the HTTP header to match. For matching
     * against the HTTP request's authority, use a headerMatch
     * with the header name ":authority". For matching a
     * request's method, use the headerName ":method".
     *
     * Generated from protobuf field <code>string header_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getHeaderName()
    {
        return $this->header_name;
    }

    /**
     * Required. The name of the HTTP header to match. For matching
     * against the HTTP request's authority, use a headerMatch
     * with the header name ":authority". For matching a
     * request's method, use the headerName ":method".
     *
     * Generated from protobuf field <code>string header_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setHeaderName($var)
    {
        GPBUtil::checkString($var, True);
        $this->header_name = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->whichOneof("type");
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(HttpHeaderMatch::class, \Google\Cloud\NetworkSecurity\V1beta1\AuthorizationPolicy_Rule_Destination_HttpHeaderMatch::class);

