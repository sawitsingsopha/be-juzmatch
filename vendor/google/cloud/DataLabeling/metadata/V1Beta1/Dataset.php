<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datalabeling/v1beta1/dataset.proto

namespace GPBMetadata\Google\Cloud\Datalabeling\V1Beta1;

class Dataset
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Datalabeling\V1Beta1\Annotation::initOnce();
        \GPBMetadata\Google\Cloud\Datalabeling\V1Beta1\AnnotationSpecSet::initOnce();
        \GPBMetadata\Google\Cloud\Datalabeling\V1Beta1\DataPayloads::initOnce();
        \GPBMetadata\Google\Cloud\Datalabeling\V1Beta1\HumanAnnotationConfig::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�$
/google/cloud/datalabeling/v1beta1/dataset.proto!google.cloud.datalabeling.v1beta1google/api/resource.proto2google/cloud/datalabeling/v1beta1/annotation.proto;google/cloud/datalabeling/v1beta1/annotation_spec_set.proto5google/cloud/datalabeling/v1beta1/data_payloads.proto?google/cloud/datalabeling/v1beta1/human_annotation_config.protogoogle/protobuf/timestamp.proto"�
Dataset
name (	
display_name (	
description (	/
create_time (2.google.protobuf.TimestampE
input_configs (2..google.cloud.datalabeling.v1beta1.InputConfig
blocking_resources (	
data_item_count (:O�AL
#datalabeling.googleapis.com/Dataset%projects/{project}/datasets/{dataset}"�
InputConfigH
text_metadata (2/.google.cloud.datalabeling.v1beta1.TextMetadataH B

gcs_source (2,.google.cloud.datalabeling.v1beta1.GcsSourceHL
bigquery_source (21.google.cloud.datalabeling.v1beta1.BigQuerySourceH>
	data_type (2+.google.cloud.datalabeling.v1beta1.DataTypeJ
annotation_type (21.google.cloud.datalabeling.v1beta1.AnnotationTypeZ
classification_metadata (29.google.cloud.datalabeling.v1beta1.ClassificationMetadataB
data_type_metadataB
source"%
TextMetadata
language_code (	"0
ClassificationMetadata
is_multi_label ("1
	GcsSource
	input_uri (	
	mime_type (	"#
BigQuerySource
	input_uri (	"�
OutputConfigL
gcs_destination (21.google.cloud.datalabeling.v1beta1.GcsDestinationH Y
gcs_folder_destination (27.google.cloud.datalabeling.v1beta1.GcsFolderDestinationH B
destination"7
GcsDestination

output_uri (	
	mime_type (	"1
GcsFolderDestination
output_folder_uri (	"�
DataItemH
image_payload (2/.google.cloud.datalabeling.v1beta1.ImagePayloadH F
text_payload (2..google.cloud.datalabeling.v1beta1.TextPayloadH H
video_payload (2/.google.cloud.datalabeling.v1beta1.VideoPayloadH 
name (	:f�Ac
$datalabeling.googleapis.com/DataItem;projects/{project}/datasets/{dataset}/dataItems/{data_item}B	
payload"�
AnnotatedDataset
name (	
display_name (	
description	 (	N
annotation_source (23.google.cloud.datalabeling.v1beta1.AnnotationSourceJ
annotation_type (21.google.cloud.datalabeling.v1beta1.AnnotationType
example_count (
completed_example_count (B
label_stats (2-.google.cloud.datalabeling.v1beta1.LabelStats/
create_time (2.google.protobuf.TimestampM
metadata
 (2;.google.cloud.datalabeling.v1beta1.AnnotatedDatasetMetadata
blocking_resources (	:~�A{
,datalabeling.googleapis.com/AnnotatedDatasetKprojects/{project}/datasets/{dataset}/annotatedDatasets/{annotated_dataset}"�

LabelStatsV
example_count (2?.google.cloud.datalabeling.v1beta1.LabelStats.ExampleCountEntry3
ExampleCountEntry
key (	
value (:8"�
AnnotatedDatasetMetadatac
image_classification_config (2<.google.cloud.datalabeling.v1beta1.ImageClassificationConfigH U
bounding_poly_config (25.google.cloud.datalabeling.v1beta1.BoundingPolyConfigH L
polyline_config (21.google.cloud.datalabeling.v1beta1.PolylineConfigH T
segmentation_config (25.google.cloud.datalabeling.v1beta1.SegmentationConfigH c
video_classification_config (2<.google.cloud.datalabeling.v1beta1.VideoClassificationConfigH [
object_detection_config (28.google.cloud.datalabeling.v1beta1.ObjectDetectionConfigH Y
object_tracking_config (27.google.cloud.datalabeling.v1beta1.ObjectTrackingConfigH F
event_config	 (2..google.cloud.datalabeling.v1beta1.EventConfigH a
text_classification_config
 (2;.google.cloud.datalabeling.v1beta1.TextClassificationConfigH f
text_entity_extraction_config (2=.google.cloud.datalabeling.v1beta1.TextEntityExtractionConfigH Y
human_annotation_config (28.google.cloud.datalabeling.v1beta1.HumanAnnotationConfigB
annotation_request_config"�
ExampleH
image_payload (2/.google.cloud.datalabeling.v1beta1.ImagePayloadH F
text_payload (2..google.cloud.datalabeling.v1beta1.TextPayloadH H
video_payload (2/.google.cloud.datalabeling.v1beta1.VideoPayloadH 
name (	B
annotations (2-.google.cloud.datalabeling.v1beta1.Annotation:��A�
#datalabeling.googleapis.com/Example^projects/{project}/datasets/{dataset}/annotatedDatasets/{annotated_dataset}/examples/{example}B	
payload*W
DataType
DATA_TYPE_UNSPECIFIED 	
IMAGE	
VIDEO
TEXT
GENERAL_DATAB�
%com.google.cloud.datalabeling.v1beta1PZMgoogle.golang.org/genproto/googleapis/cloud/datalabeling/v1beta1;datalabeling�!Google.Cloud.DataLabeling.V1Beta1�!Google\\Cloud\\DataLabeling\\V1beta1�$Google::Cloud::DataLabeling::V1beta1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

