<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/lifesciences/v2beta/workflows.proto

namespace Google\Cloud\LifeSciences\V2beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The arguments to the `RunPipeline` method. The requesting user must have
 * the `iam.serviceAccounts.actAs` permission for the Cloud Life Sciences
 * service account or the request will fail.
 *
 * Generated from protobuf message <code>google.cloud.lifesciences.v2beta.RunPipelineRequest</code>
 */
class RunPipelineRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The project and location that this request should be executed against.
     *
     * Generated from protobuf field <code>string parent = 4;</code>
     */
    private $parent = '';
    /**
     * Required. The description of the pipeline to run.
     *
     * Generated from protobuf field <code>.google.cloud.lifesciences.v2beta.Pipeline pipeline = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $pipeline = null;
    /**
     * User-defined labels to associate with the returned operation. These
     * labels are not propagated to any Google Cloud Platform resources used by
     * the operation, and can be modified at any time.
     * To associate labels with resources created while executing the operation,
     * see the appropriate resource message (for example, `VirtualMachine`).
     *
     * Generated from protobuf field <code>map<string, string> labels = 2;</code>
     */
    private $labels;
    /**
     * The name of an existing Pub/Sub topic.  The server will publish
     * messages to this topic whenever the status of the operation changes.
     * The Life Sciences Service Agent account must have publisher permissions to
     * the specified topic or notifications will not be sent.
     *
     * Generated from protobuf field <code>string pub_sub_topic = 3;</code>
     */
    private $pub_sub_topic = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           The project and location that this request should be executed against.
     *     @type \Google\Cloud\LifeSciences\V2beta\Pipeline $pipeline
     *           Required. The description of the pipeline to run.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           User-defined labels to associate with the returned operation. These
     *           labels are not propagated to any Google Cloud Platform resources used by
     *           the operation, and can be modified at any time.
     *           To associate labels with resources created while executing the operation,
     *           see the appropriate resource message (for example, `VirtualMachine`).
     *     @type string $pub_sub_topic
     *           The name of an existing Pub/Sub topic.  The server will publish
     *           messages to this topic whenever the status of the operation changes.
     *           The Life Sciences Service Agent account must have publisher permissions to
     *           the specified topic or notifications will not be sent.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Lifesciences\V2Beta\Workflows::initOnce();
        parent::__construct($data);
    }

    /**
     * The project and location that this request should be executed against.
     *
     * Generated from protobuf field <code>string parent = 4;</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * The project and location that this request should be executed against.
     *
     * Generated from protobuf field <code>string parent = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Required. The description of the pipeline to run.
     *
     * Generated from protobuf field <code>.google.cloud.lifesciences.v2beta.Pipeline pipeline = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\LifeSciences\V2beta\Pipeline|null
     */
    public function getPipeline()
    {
        return isset($this->pipeline) ? $this->pipeline : null;
    }

    public function hasPipeline()
    {
        return isset($this->pipeline);
    }

    public function clearPipeline()
    {
        unset($this->pipeline);
    }

    /**
     * Required. The description of the pipeline to run.
     *
     * Generated from protobuf field <code>.google.cloud.lifesciences.v2beta.Pipeline pipeline = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\LifeSciences\V2beta\Pipeline $var
     * @return $this
     */
    public function setPipeline($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\LifeSciences\V2beta\Pipeline::class);
        $this->pipeline = $var;

        return $this;
    }

    /**
     * User-defined labels to associate with the returned operation. These
     * labels are not propagated to any Google Cloud Platform resources used by
     * the operation, and can be modified at any time.
     * To associate labels with resources created while executing the operation,
     * see the appropriate resource message (for example, `VirtualMachine`).
     *
     * Generated from protobuf field <code>map<string, string> labels = 2;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * User-defined labels to associate with the returned operation. These
     * labels are not propagated to any Google Cloud Platform resources used by
     * the operation, and can be modified at any time.
     * To associate labels with resources created while executing the operation,
     * see the appropriate resource message (for example, `VirtualMachine`).
     *
     * Generated from protobuf field <code>map<string, string> labels = 2;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

    /**
     * The name of an existing Pub/Sub topic.  The server will publish
     * messages to this topic whenever the status of the operation changes.
     * The Life Sciences Service Agent account must have publisher permissions to
     * the specified topic or notifications will not be sent.
     *
     * Generated from protobuf field <code>string pub_sub_topic = 3;</code>
     * @return string
     */
    public function getPubSubTopic()
    {
        return $this->pub_sub_topic;
    }

    /**
     * The name of an existing Pub/Sub topic.  The server will publish
     * messages to this topic whenever the status of the operation changes.
     * The Life Sciences Service Agent account must have publisher permissions to
     * the specified topic or notifications will not be sent.
     *
     * Generated from protobuf field <code>string pub_sub_topic = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPubSubTopic($var)
    {
        GPBUtil::checkString($var, True);
        $this->pub_sub_topic = $var;

        return $this;
    }

}

