<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/speech/v1p1beta1/cloud_speech.proto

namespace GPBMetadata\Google\Cloud\Speech\V1P1Beta1;

class CloudSpeech
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Speech\V1P1Beta1\Resource::initOnce();
        \GPBMetadata\Google\Longrunning\Operations::initOnce();
        \GPBMetadata\Google\Protobuf\Any::initOnce();
        \GPBMetadata\Google\Protobuf\Duration::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Rpc\Status::initOnce();
        $pool->internalAddGeneratedFile(
            '
�+
0google/cloud/speech/v1p1beta1/cloud_speech.protogoogle.cloud.speech.v1p1beta1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto,google/cloud/speech/v1p1beta1/resource.proto#google/longrunning/operations.protogoogle/protobuf/any.protogoogle/protobuf/duration.protogoogle/protobuf/timestamp.protogoogle/rpc/status.proto"�
RecognizeRequestE
config (20.google.cloud.speech.v1p1beta1.RecognitionConfigB�AC
audio (2/.google.cloud.speech.v1p1beta1.RecognitionAudioB�A"�
LongRunningRecognizeRequestE
config (20.google.cloud.speech.v1p1beta1.RecognitionConfigB�AC
audio (2/.google.cloud.speech.v1p1beta1.RecognitionAudioB�A"�
StreamingRecognizeRequestU
streaming_config (29.google.cloud.speech.v1p1beta1.StreamingRecognitionConfigH 
audio_content (H B
streaming_request"�
StreamingRecognitionConfigE
config (20.google.cloud.speech.v1p1beta1.RecognitionConfigB�A
single_utterance (
interim_results ("�
RecognitionConfigP
encoding (2>.google.cloud.speech.v1p1beta1.RecognitionConfig.AudioEncoding
sample_rate_hertz (
audio_channel_count (/
\'enable_separate_recognition_per_channel (
language_code (	B�A"
alternative_language_codes (	
max_alternatives (
profanity_filter (C

adaptation (2/.google.cloud.speech.v1p1beta1.SpeechAdaptationE
speech_contexts (2,.google.cloud.speech.v1p1beta1.SpeechContext 
enable_word_time_offsets (
enable_word_confidence ($
enable_automatic_punctuation (&
enable_speaker_diarization (B%
diarization_speaker_count (BS
diarization_config (27.google.cloud.speech.v1p1beta1.SpeakerDiarizationConfigD
metadata	 (22.google.cloud.speech.v1p1beta1.RecognitionMetadata
model (	
use_enhanced ("�
AudioEncoding
ENCODING_UNSPECIFIED 
LINEAR16
FLAC	
MULAW
AMR

AMR_WB
OGG_OPUS
SPEEX_WITH_HEADER_BYTE
MP3"�
SpeakerDiarizationConfig"
enable_speaker_diarization (
min_speaker_count (
max_speaker_count (
speaker_tag (B�A"�
RecognitionMetadata\\
interaction_type (2B.google.cloud.speech.v1p1beta1.RecognitionMetadata.InteractionType$
industry_naics_code_of_audio (b
microphone_distance (2E.google.cloud.speech.v1p1beta1.RecognitionMetadata.MicrophoneDistancea
original_media_type (2D.google.cloud.speech.v1p1beta1.RecognitionMetadata.OriginalMediaTypee
recording_device_type (2F.google.cloud.speech.v1p1beta1.RecognitionMetadata.RecordingDeviceType
recording_device_name (	
original_mime_type (	
obfuscated_id	 (B
audio_topic
 (	"�
InteractionType 
INTERACTION_TYPE_UNSPECIFIED 

DISCUSSION
PRESENTATION

PHONE_CALL
	VOICEMAIL
PROFESSIONALLY_PRODUCED
VOICE_SEARCH
VOICE_COMMAND
	DICTATION"d
MicrophoneDistance#
MICROPHONE_DISTANCE_UNSPECIFIED 
	NEARFIELD
MIDFIELD
FARFIELD"N
OriginalMediaType#
ORIGINAL_MEDIA_TYPE_UNSPECIFIED 	
AUDIO	
VIDEO"�
RecordingDeviceType%
!RECORDING_DEVICE_TYPE_UNSPECIFIED 

SMARTPHONE
PC

PHONE_LINE
VEHICLE
OTHER_OUTDOOR_DEVICE
OTHER_INDOOR_DEVICE"/
SpeechContext
phrases (	
boost ("D
RecognitionAudio
content (H 
uri (	H B
audio_source"\\
RecognizeResponseG
results (26.google.cloud.speech.v1p1beta1.SpeechRecognitionResult"g
LongRunningRecognizeResponseG
results (26.google.cloud.speech.v1p1beta1.SpeechRecognitionResult"�
LongRunningRecognizeMetadata
progress_percent (.

start_time (2.google.protobuf.Timestamp4
last_update_time (2.google.protobuf.Timestamp
uri (	B�A"�
StreamingRecognizeResponse!
error (2.google.rpc.StatusJ
results (29.google.cloud.speech.v1p1beta1.StreamingRecognitionResultd
speech_event_type (2I.google.cloud.speech.v1p1beta1.StreamingRecognizeResponse.SpeechEventType"L
SpeechEventType
SPEECH_EVENT_UNSPECIFIED 
END_OF_SINGLE_UTTERANCE"�
StreamingRecognitionResultQ
alternatives (2;.google.cloud.speech.v1p1beta1.SpeechRecognitionAlternative
is_final (
	stability (2
result_end_time (2.google.protobuf.Duration
channel_tag (
language_code (	B�A"�
SpeechRecognitionResultQ
alternatives (2;.google.cloud.speech.v1p1beta1.SpeechRecognitionAlternative
channel_tag (
language_code (	B�A"~
SpeechRecognitionAlternative

transcript (	

confidence (6
words (2\'.google.cloud.speech.v1p1beta1.WordInfo"�
WordInfo-

start_time (2.google.protobuf.Duration+
end_time (2.google.protobuf.Duration
word (	

confidence (
speaker_tag (B�A2�
Speech�
	Recognize/.google.cloud.speech.v1p1beta1.RecognizeRequest0.google.cloud.speech.v1p1beta1.RecognizeResponse"5��� "/v1p1beta1/speech:recognize:*�Aconfig,audio�
LongRunningRecognize:.google.cloud.speech.v1p1beta1.LongRunningRecognizeRequest.google.longrunning.Operation"���+"&/v1p1beta1/speech:longrunningrecognize:*�Aconfig,audio�A<
LongRunningRecognizeResponseLongRunningRecognizeMetadata�
StreamingRecognize8.google.cloud.speech.v1p1beta1.StreamingRecognizeRequest9.google.cloud.speech.v1p1beta1.StreamingRecognizeResponse" (0I�Aspeech.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
!com.google.cloud.speech.v1p1beta1BSpeechProtoPZCgoogle.golang.org/genproto/googleapis/cloud/speech/v1p1beta1;speech��GCSbproto3'
        , true);

        static::$is_initialized = true;
    }
}

