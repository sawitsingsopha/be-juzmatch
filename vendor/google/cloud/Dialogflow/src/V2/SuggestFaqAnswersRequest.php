<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/participant.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request message for [Participants.SuggestFaqAnswers][google.cloud.dialogflow.v2.Participants.SuggestFaqAnswers].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.SuggestFaqAnswersRequest</code>
 */
class SuggestFaqAnswersRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the participant to fetch suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/participants/<Participant ID>`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * The name of the latest conversation message to compile suggestion
     * for. If empty, it will be the latest message of the conversation.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2 [(.google.api.resource_reference) = {</code>
     */
    private $latest_message = '';
    /**
     * Max number of messages prior to and including
     * [latest_message] to use as context when compiling the
     * suggestion. By default 20 and at most 50.
     *
     * Generated from protobuf field <code>int32 context_size = 3;</code>
     */
    private $context_size = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The name of the participant to fetch suggestion for.
     *           Format: `projects/<Project ID>/locations/<Location
     *           ID>/conversations/<Conversation ID>/participants/<Participant ID>`.
     *     @type string $latest_message
     *           The name of the latest conversation message to compile suggestion
     *           for. If empty, it will be the latest message of the conversation.
     *           Format: `projects/<Project ID>/locations/<Location
     *           ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *     @type int $context_size
     *           Max number of messages prior to and including
     *           [latest_message] to use as context when compiling the
     *           suggestion. By default 20 and at most 50.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Participant::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The name of the participant to fetch suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/participants/<Participant ID>`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The name of the participant to fetch suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/participants/<Participant ID>`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
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
     * The name of the latest conversation message to compile suggestion
     * for. If empty, it will be the latest message of the conversation.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2 [(.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getLatestMessage()
    {
        return $this->latest_message;
    }

    /**
     * The name of the latest conversation message to compile suggestion
     * for. If empty, it will be the latest message of the conversation.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2 [(.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setLatestMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->latest_message = $var;

        return $this;
    }

    /**
     * Max number of messages prior to and including
     * [latest_message] to use as context when compiling the
     * suggestion. By default 20 and at most 50.
     *
     * Generated from protobuf field <code>int32 context_size = 3;</code>
     * @return int
     */
    public function getContextSize()
    {
        return $this->context_size;
    }

    /**
     * Max number of messages prior to and including
     * [latest_message] to use as context when compiling the
     * suggestion. By default 20 and at most 50.
     *
     * Generated from protobuf field <code>int32 context_size = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setContextSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->context_size = $var;

        return $this;
    }

}

