<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/dataflow/v1beta3/messages.proto

namespace GPBMetadata\Google\Dataflow\V1Beta3;

class Messages
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Protobuf\Struct::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
&google/dataflow/v1beta3/messages.protogoogle.dataflow.v1beta3google/protobuf/struct.protogoogle/protobuf/timestamp.protogoogle/api/client.proto"�

JobMessage

id (	(
time (2.google.protobuf.Timestamp
message_text (	I
message_importance (2-.google.dataflow.v1beta3.JobMessageImportance"�
StructuredMessage
message_text (	
message_key (	H

parameters (24.google.dataflow.v1beta3.StructuredMessage.Parameter?
	Parameter
key (	%
value (2.google.protobuf.Value"�
AutoscalingEvent
current_num_workers (
target_num_workers (R

event_type (2>.google.dataflow.v1beta3.AutoscalingEvent.AutoscalingEventType?
description (2*.google.dataflow.v1beta3.StructuredMessage(
time (2.google.protobuf.Timestamp
worker_pool (	"�
AutoscalingEventType
TYPE_UNKNOWN 
TARGET_NUM_WORKERS_CHANGED
CURRENT_NUM_WORKERS_CHANGED
ACTUATION_FAILURE
	NO_CHANGE"�
ListJobMessagesRequest

project_id (	
job_id (	I
minimum_importance (2-.google.dataflow.v1beta3.JobMessageImportance
	page_size (

page_token (	.

start_time (2.google.protobuf.Timestamp,
end_time (2.google.protobuf.Timestamp
location (	"�
ListJobMessagesResponse9
job_messages (2#.google.dataflow.v1beta3.JobMessage
next_page_token (	E
autoscaling_events (2).google.dataflow.v1beta3.AutoscalingEvent*�
JobMessageImportance"
JOB_MESSAGE_IMPORTANCE_UNKNOWN 
JOB_MESSAGE_DEBUG
JOB_MESSAGE_DETAILED
JOB_MESSAGE_BASIC
JOB_MESSAGE_WARNING
JOB_MESSAGE_ERROR2�
MessagesV1Beta3v
ListJobMessages/.google.dataflow.v1beta3.ListJobMessagesRequest0.google.dataflow.v1beta3.ListJobMessagesResponse" ��Adataflow.googleapis.com�A�https://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/compute,https://www.googleapis.com/auth/compute.readonly,https://www.googleapis.com/auth/userinfo.emailB�
com.google.dataflow.v1beta3BMessagesProtoPZ?google.golang.org/genproto/googleapis/dataflow/v1beta3;dataflow�Google.Cloud.Dataflow.V1Beta3�Google\\Cloud\\Dataflow\\V1beta3� Google::Cloud::Dataflow::V1beta3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

