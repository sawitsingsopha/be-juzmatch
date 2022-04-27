<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/dataflow/v1beta3/streaming.proto

namespace Google\Cloud\Dataflow\V1beta3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Streaming appliance snapshot configuration.
 *
 * Generated from protobuf message <code>google.dataflow.v1beta3.StreamingApplianceSnapshotConfig</code>
 */
class StreamingApplianceSnapshotConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * If set, indicates the snapshot id for the snapshot being performed.
     *
     * Generated from protobuf field <code>string snapshot_id = 1;</code>
     */
    private $snapshot_id = '';
    /**
     * Indicates which endpoint is used to import appliance state.
     *
     * Generated from protobuf field <code>string import_state_endpoint = 2;</code>
     */
    private $import_state_endpoint = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $snapshot_id
     *           If set, indicates the snapshot id for the snapshot being performed.
     *     @type string $import_state_endpoint
     *           Indicates which endpoint is used to import appliance state.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Dataflow\V1Beta3\Streaming::initOnce();
        parent::__construct($data);
    }

    /**
     * If set, indicates the snapshot id for the snapshot being performed.
     *
     * Generated from protobuf field <code>string snapshot_id = 1;</code>
     * @return string
     */
    public function getSnapshotId()
    {
        return $this->snapshot_id;
    }

    /**
     * If set, indicates the snapshot id for the snapshot being performed.
     *
     * Generated from protobuf field <code>string snapshot_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSnapshotId($var)
    {
        GPBUtil::checkString($var, True);
        $this->snapshot_id = $var;

        return $this;
    }

    /**
     * Indicates which endpoint is used to import appliance state.
     *
     * Generated from protobuf field <code>string import_state_endpoint = 2;</code>
     * @return string
     */
    public function getImportStateEndpoint()
    {
        return $this->import_state_endpoint;
    }

    /**
     * Indicates which endpoint is used to import appliance state.
     *
     * Generated from protobuf field <code>string import_state_endpoint = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setImportStateEndpoint($var)
    {
        GPBUtil::checkString($var, True);
        $this->import_state_endpoint = $var;

        return $this;
    }

}
