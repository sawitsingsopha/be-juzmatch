<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/human_agent_assistant_event.proto

namespace GPBMetadata\Google\Cloud\Dialogflow\V2;

class HumanAgentAssistantEvent
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Participant::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
<google/cloud/dialogflow/v2/human_agent_assistant_event.protogoogle.cloud.dialogflow.v2google/api/annotations.proto"�
HumanAgentAssistantEvent
conversation (	
participant (	H
suggestion_results (2,.google.cloud.dialogflow.v2.SuggestionResultB�
com.google.cloud.dialogflow.v2BHumanAgentAssistantEventProtoPZDgoogle.golang.org/genproto/googleapis/cloud/dialogflow/v2;dialogflow��DF�Google.Cloud.Dialogflow.V2bproto3'
        , true);

        static::$is_initialized = true;
    }
}

