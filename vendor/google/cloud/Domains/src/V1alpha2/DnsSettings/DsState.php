<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/domains/v1alpha2/domains.proto

namespace Google\Cloud\Domains\V1alpha2\DnsSettings;

use UnexpectedValueException;

/**
 * The publication state of DS records for a `Registration`.
 *
 * Protobuf type <code>google.cloud.domains.v1alpha2.DnsSettings.DsState</code>
 */
class DsState
{
    /**
     * DS state is unspecified.
     *
     * Generated from protobuf enum <code>DS_STATE_UNSPECIFIED = 0;</code>
     */
    const DS_STATE_UNSPECIFIED = 0;
    /**
     * DNSSEC is disabled for this domain. No DS records for this domain are
     * published in the parent DNS zone.
     *
     * Generated from protobuf enum <code>DS_RECORDS_UNPUBLISHED = 1;</code>
     */
    const DS_RECORDS_UNPUBLISHED = 1;
    /**
     * DNSSEC is enabled for this domain. Appropriate DS records for this domain
     * are published in the parent DNS zone. This option is valid only if the
     * DNS zone referenced in the `Registration`'s `dns_provider` field is
     * already DNSSEC-signed.
     *
     * Generated from protobuf enum <code>DS_RECORDS_PUBLISHED = 2;</code>
     */
    const DS_RECORDS_PUBLISHED = 2;

    private static $valueToName = [
        self::DS_STATE_UNSPECIFIED => 'DS_STATE_UNSPECIFIED',
        self::DS_RECORDS_UNPUBLISHED => 'DS_RECORDS_UNPUBLISHED',
        self::DS_RECORDS_PUBLISHED => 'DS_RECORDS_PUBLISHED',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(DsState::class, \Google\Cloud\Domains\V1alpha2\DnsSettings_DsState::class);

