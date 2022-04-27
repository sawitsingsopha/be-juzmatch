<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/dataflow/v1beta3/metrics.proto

namespace GPBMetadata\Google\Dataflow\V1Beta3;

class Metrics
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
�
%google/dataflow/v1beta3/metrics.protogoogle.dataflow.v1beta3google/protobuf/struct.protogoogle/protobuf/timestamp.protogoogle/api/client.proto"�
MetricStructuredName
origin (	
name (	K
context (2:.google.dataflow.v1beta3.MetricStructuredName.ContextEntry.
ContextEntry
key (	
value (	:8"�
MetricUpdate;
name (2-.google.dataflow.v1beta3.MetricStructuredName
kind (	

cumulative (&
scalar (2.google.protobuf.Value(
mean_sum (2.google.protobuf.Value*

mean_count (2.google.protobuf.Value#
set (2.google.protobuf.Value,
distribution (2.google.protobuf.Value%
gauge (2.google.protobuf.Value(
internal (2.google.protobuf.Value/
update_time	 (2.google.protobuf.Timestamp"|
GetJobMetricsRequest

project_id (	
job_id (	.

start_time (2.google.protobuf.Timestamp
location (	"u

JobMetrics/
metric_time (2.google.protobuf.Timestamp6
metrics (2%.google.dataflow.v1beta3.MetricUpdate"|
GetJobExecutionDetailsRequest

project_id (	
job_id (	
location (	
	page_size (

page_token (	"�
ProgressTimeseries
current_progress (F
data_points (21.google.dataflow.v1beta3.ProgressTimeseries.Point@
Point(
time (2.google.protobuf.Timestamp
value ("�
StageSummary
stage_id (	6
state (2\'.google.dataflow.v1beta3.ExecutionState.

start_time (2.google.protobuf.Timestamp,
end_time (2.google.protobuf.Timestamp=
progress (2+.google.dataflow.v1beta3.ProgressTimeseries6
metrics (2%.google.dataflow.v1beta3.MetricUpdate"e
JobExecutionDetails5
stages (2%.google.dataflow.v1beta3.StageSummary
next_page_token (	"�
GetStageExecutionDetailsRequest

project_id (	
job_id (	
location (	
stage_id (	
	page_size (

page_token (	.

start_time (2.google.protobuf.Timestamp,
end_time (2.google.protobuf.Timestamp"�
WorkItemDetails
task_id (	

attempt_id (	.

start_time (2.google.protobuf.Timestamp,
end_time (2.google.protobuf.Timestamp6
state (2\'.google.dataflow.v1beta3.ExecutionState=
progress (2+.google.dataflow.v1beta3.ProgressTimeseries6
metrics (2%.google.dataflow.v1beta3.MetricUpdate"b
WorkerDetails
worker_name (	<

work_items (2(.google.dataflow.v1beta3.WorkItemDetails"i
StageExecutionDetails7
workers (2&.google.dataflow.v1beta3.WorkerDetails
next_page_token (	*�
ExecutionState
EXECUTION_STATE_UNKNOWN 
EXECUTION_STATE_NOT_STARTED
EXECUTION_STATE_RUNNING
EXECUTION_STATE_SUCCEEDED
EXECUTION_STATE_FAILED
EXECUTION_STATE_CANCELLED2�
MetricsV1Beta3e
GetJobMetrics-.google.dataflow.v1beta3.GetJobMetricsRequest#.google.dataflow.v1beta3.JobMetrics" �
GetJobExecutionDetails6.google.dataflow.v1beta3.GetJobExecutionDetailsRequest,.google.dataflow.v1beta3.JobExecutionDetails" �
GetStageExecutionDetails8.google.dataflow.v1beta3.GetStageExecutionDetailsRequest..google.dataflow.v1beta3.StageExecutionDetails" ��Adataflow.googleapis.com�A�https://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/compute,https://www.googleapis.com/auth/compute.readonly,https://www.googleapis.com/auth/userinfo.emailB�
com.google.dataflow.v1beta3BMetricsProtoPZ?google.golang.org/genproto/googleapis/dataflow/v1beta3;dataflow�Google.Cloud.Dataflow.V1Beta3�Google\\Cloud\\Dataflow\\V1beta3� Google::Cloud::Dataflow::V1beta3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

