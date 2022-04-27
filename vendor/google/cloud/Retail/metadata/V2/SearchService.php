<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/retail/v2/search_service.proto

namespace GPBMetadata\Google\Cloud\Retail\V2;

class SearchService
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
        \GPBMetadata\Google\Cloud\Retail\V2\Common::initOnce();
        \GPBMetadata\Google\Cloud\Retail\V2\Product::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Struct::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Protobuf\Wrappers::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
+google/cloud/retail/v2/search_service.protogoogle.cloud.retail.v2google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto#google/cloud/retail/v2/common.proto$google/cloud/retail/v2/product.proto google/protobuf/field_mask.protogoogle/protobuf/struct.protogoogle/protobuf/timestamp.protogoogle/protobuf/wrappers.proto"�
SearchRequest
	placement (	B�A1
branch (	B!�A
retail.googleapis.com/Branch
query (	

visitor_id (	B�A3
	user_info (2 .google.cloud.retail.v2.UserInfo
	page_size (

page_token (	
offset	 (
filter
 (	
canonical_filter (	
order_by (	D
facet_specs (2/.google.cloud.retail.v2.SearchRequest.FacetSpecR
dynamic_facet_spec (26.google.cloud.retail.v2.SearchRequest.DynamicFacetSpecC

boost_spec (2/.google.cloud.retail.v2.SearchRequest.BoostSpecV
query_expansion_spec (28.google.cloud.retail.v2.SearchRequest.QueryExpansionSpec
variant_rollup_keys (	
page_categories (	�
	FacetSpecP
	facet_key (28.google.cloud.retail.v2.SearchRequest.FacetSpec.FacetKeyB�A
limit (
excluded_filter_keys (	
enable_dynamic_position (�
FacetKey
key (	B�A3
	intervals (2 .google.cloud.retail.v2.Interval
restricted_values (	
prefixes (	
contains	 (	
order_by (	
query (	�
DynamicFacetSpecI
mode (2;.google.cloud.retail.v2.SearchRequest.DynamicFacetSpec.Mode"7
Mode
MODE_UNSPECIFIED 
DISABLED
ENABLED�
	BoostSpeca
condition_boost_specs (2B.google.cloud.retail.v2.SearchRequest.BoostSpec.ConditionBoostSpec6
ConditionBoostSpec
	condition (	
boost (�
QueryExpansionSpecU
	condition (2B.google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition">
	Condition
CONDITION_UNSPECIFIED 
DISABLED
AUTO"�
SearchResponseD
results (23.google.cloud.retail.v2.SearchResponse.SearchResult<
facets (2,.google.cloud.retail.v2.SearchResponse.Facet

total_size (
corrected_query (	
attribution_token (	
next_page_token (	W
query_expansion_info (29.google.cloud.retail.v2.SearchResponse.QueryExpansionInfo
redirect_uri
 (	�
SearchResult

id (	0
product (2.google.cloud.retail.v2.Product
matching_variant_count (o
matching_variant_fields (2N.google.cloud.retail.v2.SearchResponse.SearchResult.MatchingVariantFieldsEntryk
variant_rollup_values (2L.google.cloud.retail.v2.SearchResponse.SearchResult.VariantRollupValuesEntryX
MatchingVariantFieldsEntry
key (	)
value (2.google.protobuf.FieldMask:8R
VariantRollupValuesEntry
key (	%
value (2.google.protobuf.Value:8�
Facet
key (	G
values (27.google.cloud.retail.v2.SearchResponse.Facet.FacetValue
dynamic_facet (q

FacetValue
value (	H 4
interval (2 .google.cloud.retail.v2.IntervalH 
count (B
facet_value,
QueryExpansionInfo
expanded_query (2�
SearchService�
Search%.google.cloud.retail.v2.SearchRequest&.google.cloud.retail.v2.SearchResponse"P���J"E/v2/{placement=projects/*/locations/*/catalogs/*/placements/*}:search:*I�Aretail.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
com.google.cloud.retail.v2BSearchServiceProtoPZ<google.golang.org/genproto/googleapis/cloud/retail/v2;retail�RETAIL�Google.Cloud.Retail.V2�Google\\Cloud\\Retail\\V2�Google::Cloud::Retail::V2bproto3'
        , true);

        static::$is_initialized = true;
    }
}

