<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/notebooks/v1beta1/instance.proto

namespace GPBMetadata\Google\Cloud\Notebooks\V1Beta1;

class Instance
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Notebooks\V1Beta1\Environment::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
-google/cloud/notebooks/v1beta1/instance.protogoogle.cloud.notebooks.v1beta1google/api/resource.proto0google/cloud/notebooks/v1beta1/environment.protogoogle/protobuf/timestamp.protogoogle/api/annotations.proto"�
Instance
name (	B�A;
vm_image (2\'.google.cloud.notebooks.v1beta1.VmImageH I
container_image (2..google.cloud.notebooks.v1beta1.ContainerImageH 
post_startup_script (	
	proxy_uri (	B�A
instance_owners (	B�A
service_account (	
machine_type (	B�AV
accelerator_config	 (2:.google.cloud.notebooks.v1beta1.Instance.AcceleratorConfigB
state
 (2..google.cloud.notebooks.v1beta1.Instance.StateB�A
install_gpu_driver (
custom_gpu_driver_path (	N
boot_disk_type (21.google.cloud.notebooks.v1beta1.Instance.DiskTypeB�A
boot_disk_size_gb (B�AN
data_disk_type (21.google.cloud.notebooks.v1beta1.Instance.DiskTypeB�A
data_disk_size_gb (B�A 
no_remove_data_disk (B�AU
disk_encryption (27.google.cloud.notebooks.v1beta1.Instance.DiskEncryptionB�A
kms_key (	B�A
no_public_ip (
no_proxy_access (
network (	
subnet (	D
labels (24.google.cloud.notebooks.v1beta1.Instance.LabelsEntryH
metadata (26.google.cloud.notebooks.v1beta1.Instance.MetadataEntry4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�Ao
AcceleratorConfigF
type (28.google.cloud.notebooks.v1beta1.Instance.AcceleratorType

core_count (-
LabelsEntry
key (	
value (	:8/
MetadataEntry
key (	
value (	:8"�
AcceleratorType 
ACCELERATOR_TYPE_UNSPECIFIED 
NVIDIA_TESLA_K80
NVIDIA_TESLA_P100
NVIDIA_TESLA_V100
NVIDIA_TESLA_P4
NVIDIA_TESLA_T4
NVIDIA_TESLA_T4_VWS
NVIDIA_TESLA_P100_VWS	
NVIDIA_TESLA_P4_VWS


TPU_V2

TPU_V3"�
State
STATE_UNSPECIFIED 
STARTING
PROVISIONING

ACTIVE
STOPPING
STOPPED
DELETED
	UPGRADING
INITIALIZING
REGISTERING	"S
DiskType
DISK_TYPE_UNSPECIFIED 
PD_STANDARD

PD_SSD
PD_BALANCED"E
DiskEncryption
DISK_ENCRYPTION_UNSPECIFIED 
GMEK
CMEK:O�AL
!notebooks.googleapis.com/Instance\'projects/{project}/instances/{instance}B
environmentB�
"com.google.cloud.notebooks.v1beta1BInstanceProtoPZGgoogle.golang.org/genproto/googleapis/cloud/notebooks/v1beta1;notebooks�Google.Cloud.Notebooks.V1Beta1�Google\\Cloud\\Notebooks\\V1beta1�!Google::Cloud::Notebooks::V1beta1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

