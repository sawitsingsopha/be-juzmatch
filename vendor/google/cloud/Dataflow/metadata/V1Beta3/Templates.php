<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/dataflow/v1beta3/templates.proto

namespace GPBMetadata\Google\Dataflow\V1Beta3;

class Templates
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Dataflow\V1Beta3\Environment::initOnce();
        \GPBMetadata\Google\Dataflow\V1Beta3\Jobs::initOnce();
        \GPBMetadata\Google\Rpc\Status::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        $pool->internalAddGeneratedFile(
            '
�4
\'google/dataflow/v1beta3/templates.protogoogle.dataflow.v1beta3)google/dataflow/v1beta3/environment.proto"google/dataflow/v1beta3/jobs.protogoogle/rpc/status.protogoogle/api/client.proto"G
LaunchFlexTemplateResponse)
job (2.google.dataflow.v1beta3.Job"�
ContainerSpec
image (	;
metadata (2).google.dataflow.v1beta3.TemplateMetadata2
sdk_info (2 .google.dataflow.v1beta3.SDKInfoT
default_environment (27.google.dataflow.v1beta3.FlexTemplateRuntimeEnvironment"�
LaunchFlexTemplateParameter
job_name (	@
container_spec (2&.google.dataflow.v1beta3.ContainerSpecH !
container_spec_gcs_path (	H X

parameters (2D.google.dataflow.v1beta3.LaunchFlexTemplateParameter.ParametersEntry_
launch_options (2G.google.dataflow.v1beta3.LaunchFlexTemplateParameter.LaunchOptionsEntryL
environment (27.google.dataflow.v1beta3.FlexTemplateRuntimeEnvironment
update (p
transform_name_mappings	 (2O.google.dataflow.v1beta3.LaunchFlexTemplateParameter.TransformNameMappingsEntry1
ParametersEntry
key (	
value (	:84
LaunchOptionsEntry
key (	
value (	:8<
TransformNameMappingsEntry
key (	
value (	:8B

template"�
FlexTemplateRuntimeEnvironment
num_workers (
max_workers (
zone (	
service_account_email (	
temp_location (	
machine_type (	
additional_experiments (	
network (	

subnetwork	 (	q
additional_user_labels
 (2Q.google.dataflow.v1beta3.FlexTemplateRuntimeEnvironment.AdditionalUserLabelsEntry
kms_key_name (	O
ip_configuration (25.google.dataflow.v1beta3.WorkerIPAddressConfiguration
worker_region (	
worker_zone (	
enable_streaming_engine (H
flexrs_goal (23.google.dataflow.v1beta3.FlexResourceSchedulingGoal
staging_location (	
sdk_container_image (	;
AdditionalUserLabelsEntry
key (	
value (	:8"�
LaunchFlexTemplateRequest

project_id (	N
launch_parameter (24.google.dataflow.v1beta3.LaunchFlexTemplateParameter
location (	
validate_only ("�
RuntimeEnvironment
num_workers (
max_workers (
zone (	
service_account_email (	
temp_location (	"
bypass_temp_dir_validation (
machine_type (	
additional_experiments (	
network (	

subnetwork	 (	e
additional_user_labels
 (2E.google.dataflow.v1beta3.RuntimeEnvironment.AdditionalUserLabelsEntry
kms_key_name (	O
ip_configuration (25.google.dataflow.v1beta3.WorkerIPAddressConfiguration
worker_region (	
worker_zone (	
enable_streaming_engine (;
AdditionalUserLabelsEntry
key (	
value (	:8"�
ParameterMetadata
name (	
label (	
	help_text (	
is_optional (
regexes (	:

param_type (2&.google.dataflow.v1beta3.ParameterTypeW
custom_metadata (2>.google.dataflow.v1beta3.ParameterMetadata.CustomMetadataEntry5
CustomMetadataEntry
key (	
value (	:8"u
TemplateMetadata
name (	
description (	>

parameters (2*.google.dataflow.v1beta3.ParameterMetadata"�
SDKInfo;
language (2).google.dataflow.v1beta3.SDKInfo.Language
version (	"-
Language
UNKNOWN 
JAVA

PYTHON"�
RuntimeMetadata2
sdk_info (2 .google.dataflow.v1beta3.SDKInfo>

parameters (2*.google.dataflow.v1beta3.ParameterMetadata"�
CreateJobFromTemplateRequest

project_id (	
job_name (	
gcs_path (	H Y

parameters (2E.google.dataflow.v1beta3.CreateJobFromTemplateRequest.ParametersEntry@
environment (2+.google.dataflow.v1beta3.RuntimeEnvironment
location (	1
ParametersEntry
key (	
value (	:8B

template"�
GetTemplateRequest

project_id (	
gcs_path (	H F
view (28.google.dataflow.v1beta3.GetTemplateRequest.TemplateView
location (	"!
TemplateView
METADATA_ONLY B

template"�
GetTemplateResponse"
status (2.google.rpc.Status;
metadata (2).google.dataflow.v1beta3.TemplateMetadataP
template_type (29.google.dataflow.v1beta3.GetTemplateResponse.TemplateTypeB
runtime_metadata (2(.google.dataflow.v1beta3.RuntimeMetadata"1
TemplateType
UNKNOWN 

LEGACY
FLEX"�
LaunchTemplateParameters
job_name (	U

parameters (2A.google.dataflow.v1beta3.LaunchTemplateParameters.ParametersEntry@
environment (2+.google.dataflow.v1beta3.RuntimeEnvironment
update (k
transform_name_mapping (2K.google.dataflow.v1beta3.LaunchTemplateParameters.TransformNameMappingEntry1
ParametersEntry
key (	
value (	:8;
TransformNameMappingEntry
key (	
value (	:8"�
LaunchTemplateRequest

project_id (	
validate_only (
gcs_path (	H P
dynamic_template (24.google.dataflow.v1beta3.DynamicTemplateLaunchParamsH L
launch_parameters (21.google.dataflow.v1beta3.LaunchTemplateParameters
location (	B

template"C
LaunchTemplateResponse)
job (2.google.dataflow.v1beta3.Job"�
InvalidTemplateParametersc
parameter_violations (2E.google.dataflow.v1beta3.InvalidTemplateParameters.ParameterViolation<
ParameterViolation
	parameter (	
description (	"I
DynamicTemplateLaunchParams
gcs_path (	
staging_location (	*�
ParameterType
DEFAULT 
TEXT
GCS_READ_BUCKET
GCS_WRITE_BUCKET
GCS_READ_FILE
GCS_WRITE_FILE
GCS_READ_FOLDER
GCS_WRITE_FOLDER
PUBSUB_TOPIC
PUBSUB_SUBSCRIPTION	2�
TemplatesServicen
CreateJobFromTemplate5.google.dataflow.v1beta3.CreateJobFromTemplateRequest.google.dataflow.v1beta3.Job" s
LaunchTemplate..google.dataflow.v1beta3.LaunchTemplateRequest/.google.dataflow.v1beta3.LaunchTemplateResponse" j
GetTemplate+.google.dataflow.v1beta3.GetTemplateRequest,.google.dataflow.v1beta3.GetTemplateResponse" ��Adataflow.googleapis.com�A�https://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/compute,https://www.googleapis.com/auth/compute.readonly,https://www.googleapis.com/auth/userinfo.email2�
FlexTemplatesService
LaunchFlexTemplate2.google.dataflow.v1beta3.LaunchFlexTemplateRequest3.google.dataflow.v1beta3.LaunchFlexTemplateResponse" ��Adataflow.googleapis.com�A�https://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/compute,https://www.googleapis.com/auth/compute.readonly,https://www.googleapis.com/auth/userinfo.emailB�
com.google.dataflow.v1beta3BTemplatesProtoPZ?google.golang.org/genproto/googleapis/dataflow/v1beta3;dataflow�Google.Cloud.Dataflow.V1Beta3�Google\\Cloud\\Dataflow\\V1beta3� Google::Cloud::Dataflow::V1beta3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

