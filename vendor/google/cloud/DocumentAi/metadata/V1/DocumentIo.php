<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/documentai/v1/document_io.proto

namespace GPBMetadata\Google\Cloud\Documentai\V1;

class DocumentIo
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
,google/cloud/documentai/v1/document_io.protogoogle.cloud.documentai.v1"1
RawDocument
content (
	mime_type (	"1
GcsDocument
gcs_uri (	
	mime_type (	"J
GcsDocuments:
	documents (2\'.google.cloud.documentai.v1.GcsDocument"#
	GcsPrefix
gcs_uri_prefix (	"�
BatchDocumentsInputConfig;

gcs_prefix (2%.google.cloud.documentai.v1.GcsPrefixH A
gcs_documents (2(.google.cloud.documentai.v1.GcsDocumentsH B
source"�
DocumentOutputConfig]
gcs_output_config (2@.google.cloud.documentai.v1.DocumentOutputConfig.GcsOutputConfigH "
GcsOutputConfig
gcs_uri (	B
destinationB�
com.google.cloud.documentai.v1BDocumentIoProtoPZDgoogle.golang.org/genproto/googleapis/cloud/documentai/v1;documentai�Google.Cloud.DocumentAI.V1�Google\\Cloud\\DocumentAI\\V1�Google::Cloud::DocumentAI::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

