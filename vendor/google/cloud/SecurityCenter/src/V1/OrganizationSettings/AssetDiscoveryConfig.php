<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v1/organization_settings.proto

namespace Google\Cloud\SecurityCenter\V1\OrganizationSettings;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The configuration used for Asset Discovery runs.
 *
 * Generated from protobuf message <code>google.cloud.securitycenter.v1.OrganizationSettings.AssetDiscoveryConfig</code>
 */
class AssetDiscoveryConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * The project ids to use for filtering asset discovery.
     *
     * Generated from protobuf field <code>repeated string project_ids = 1;</code>
     */
    private $project_ids;
    /**
     * The mode to use for filtering asset discovery.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v1.OrganizationSettings.AssetDiscoveryConfig.InclusionMode inclusion_mode = 2;</code>
     */
    private $inclusion_mode = 0;
    /**
     * The folder ids to use for filtering asset discovery.
     * It consists of only digits, e.g., 756619654966.
     *
     * Generated from protobuf field <code>repeated string folder_ids = 3;</code>
     */
    private $folder_ids;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $project_ids
     *           The project ids to use for filtering asset discovery.
     *     @type int $inclusion_mode
     *           The mode to use for filtering asset discovery.
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $folder_ids
     *           The folder ids to use for filtering asset discovery.
     *           It consists of only digits, e.g., 756619654966.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycenter\V1\OrganizationSettings::initOnce();
        parent::__construct($data);
    }

    /**
     * The project ids to use for filtering asset discovery.
     *
     * Generated from protobuf field <code>repeated string project_ids = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getProjectIds()
    {
        return $this->project_ids;
    }

    /**
     * The project ids to use for filtering asset discovery.
     *
     * Generated from protobuf field <code>repeated string project_ids = 1;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setProjectIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->project_ids = $arr;

        return $this;
    }

    /**
     * The mode to use for filtering asset discovery.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v1.OrganizationSettings.AssetDiscoveryConfig.InclusionMode inclusion_mode = 2;</code>
     * @return int
     */
    public function getInclusionMode()
    {
        return $this->inclusion_mode;
    }

    /**
     * The mode to use for filtering asset discovery.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v1.OrganizationSettings.AssetDiscoveryConfig.InclusionMode inclusion_mode = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setInclusionMode($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\SecurityCenter\V1\OrganizationSettings\AssetDiscoveryConfig\InclusionMode::class);
        $this->inclusion_mode = $var;

        return $this;
    }

    /**
     * The folder ids to use for filtering asset discovery.
     * It consists of only digits, e.g., 756619654966.
     *
     * Generated from protobuf field <code>repeated string folder_ids = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFolderIds()
    {
        return $this->folder_ids;
    }

    /**
     * The folder ids to use for filtering asset discovery.
     * It consists of only digits, e.g., 756619654966.
     *
     * Generated from protobuf field <code>repeated string folder_ids = 3;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFolderIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->folder_ids = $arr;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AssetDiscoveryConfig::class, \Google\Cloud\SecurityCenter\V1\OrganizationSettings_AssetDiscoveryConfig::class);

