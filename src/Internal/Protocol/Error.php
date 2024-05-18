<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

enum Error: int
{
    case UNKNOWN_SERVER_ERROR = -1;
    case NONE = 0;
    case OFFSET_OUT_OF_RANGE = 1;
    case CORRUPT_MESSAGE = 2;
    case UNKNOWN_TOPIC_OR_PARTITION = 3;
    case INVALID_FETCH_SIZE = 4;
    case LEADER_NOT_AVAILABLE = 5;
    case NOT_LEADER_OR_FOLLOWER = 6;
    case REQUEST_TIMED_OUT = 7;
    case BROKER_NOT_AVAILABLE = 8;
    case REPLICA_NOT_AVAILABLE = 9;
    case MESSAGE_TOO_LARGE = 10;
    case STALE_CONTROLLER_EPOCH = 11;
    case OFFSET_METADATA_TOO_LARGE = 12;
    case NETWORK_EXCEPTION = 13;
    case COORDINATOR_LOAD_IN_PROGRESS = 14;
    case COORDINATOR_NOT_AVAILABLE = 15;
    case NOT_COORDINATOR = 16;
    case INVALID_TOPIC_EXCEPTION = 17;
    case RECORD_LIST_TOO_LARGE = 18;
    case NOT_ENOUGH_REPLICAS = 19;
    case NOT_ENOUGH_REPLICAS_AFTER_APPEND = 20;
    case INVALID_REQUIRED_ACKS = 21;
    case ILLEGAL_GENERATION = 22;
    case INCONSISTENT_GROUP_PROTOCOL = 23;
    case INVALID_GROUP_ID = 24;
    case UNKNOWN_MEMBER_ID = 25;
    case INVALID_SESSION_TIMEOUT = 26;
    case REBALANCE_IN_PROGRESS = 27;
    case INVALID_COMMIT_OFFSET_SIZE = 28;
    case TOPIC_AUTHORIZATION_FAILED = 29;
    case GROUP_AUTHORIZATION_FAILED = 30;
    case CLUSTER_AUTHORIZATION_FAILED = 31;
    case INVALID_TIMESTAMP = 32;
    case UNSUPPORTED_SASL_MECHANISM = 33;
    case ILLEGAL_SASL_STATE = 34;
    case UNSUPPORTED_VERSION = 35;
    case TOPIC_ALREADY_EXISTS = 36;
    case INVALID_PARTITIONS = 37;
    case INVALID_REPLICATION_FACTOR = 38;
    case INVALID_REPLICA_ASSIGNMENT = 39;
    case INVALID_CONFIG = 40;
    case NOT_CONTROLLER = 41;
    case INVALID_REQUEST = 42;
    case UNSUPPORTED_FOR_MESSAGE_FORMAT = 43;
    case POLICY_VIOLATION = 44;
    case OUT_OF_ORDER_SEQUENCE_NUMBER = 45;
    case DUPLICATE_SEQUENCE_NUMBER = 46;
    case INVALID_PRODUCER_EPOCH = 47;
    case INVALID_TXN_STATE = 48;
    case INVALID_PRODUCER_ID_MAPPING = 49;
    case INVALID_TRANSACTION_TIMEOUT = 50;
    case CONCURRENT_TRANSACTIONS = 51;
    case TRANSACTION_COORDINATOR_FENCED = 52;
    case TRANSACTIONAL_ID_AUTHORIZATION_FAILED = 53;
    case SECURITY_DISABLED = 54;
    case OPERATION_NOT_ATTEMPTED = 55;
    case KAFKA_STORAGE_ERROR = 56;
    case LOG_DIR_NOT_FOUND = 57;
    case SASL_AUTHENTICATION_FAILED = 58;
    case UNKNOWN_PRODUCER_ID = 59;
    case REASSIGNMENT_IN_PROGRESS = 60;
    case DELEGATION_TOKEN_AUTH_DISABLED = 61;
    case DELEGATION_TOKEN_NOT_FOUND = 62;
    case DELEGATION_TOKEN_OWNER_MISMATCH = 63;
    case DELEGATION_TOKEN_REQUEST_NOT_ALLOWED = 64;
    case DELEGATION_TOKEN_AUTHORIZATION_FAILED = 65;
    case DELEGATION_TOKEN_EXPIRED = 66;
    case INVALID_PRINCIPAL_TYPE = 67;
    case NON_EMPTY_GROUP = 68;
    case GROUP_ID_NOT_FOUND = 69;
    case FETCH_SESSION_ID_NOT_FOUND = 70;
    case INVALID_FETCH_SESSION_EPOCH = 71;
    case LISTENER_NOT_FOUND = 72;
    case TOPIC_DELETION_DISABLED = 73;
    case FENCED_LEADER_EPOCH = 74;
    case UNKNOWN_LEADER_EPOCH = 75;
    case UNSUPPORTED_COMPRESSION_TYPE = 76;
    case STALE_BROKER_EPOCH = 77;
    case OFFSET_NOT_AVAILABLE = 78;
    case MEMBER_ID_REQUIRED = 79;
    case PREFERRED_LEADER_NOT_AVAILABLE = 80;
    case GROUP_MAX_SIZE_REACHED = 81;
    case FENCED_INSTANCE_ID = 82;
    case ELIGIBLE_LEADERS_NOT_AVAILABLE = 83;
    case ELECTION_NOT_NEEDED = 84;
    case NO_REASSIGNMENT_IN_PROGRESS = 85;
    case GROUP_SUBSCRIBED_TO_TOPIC = 86;
    case INVALID_RECORD = 87;
    case UNSTABLE_OFFSET_COMMIT = 88;
    case THROTTLING_QUOTA_EXCEEDED = 89;
    case PRODUCER_FENCED = 90;
    case RESOURCE_NOT_FOUND = 91;
    case DUPLICATE_RESOURCE = 92;
    case UNACCEPTABLE_CREDENTIAL = 93;
    case INCONSISTENT_VOTER_SET = 94;
    case INVALID_UPDATE_VERSION = 95;
    case FEATURE_UPDATE_FAILED = 96;
    case PRINCIPAL_DESERIALIZATION_FAILURE = 97;
    case SNAPSHOT_NOT_FOUND = 98;
    case POSITION_OUT_OF_RANGE = 99;
    case UNKNOWN_TOPIC_ID = 100;
    case DUPLICATE_BROKER_REGISTRATION = 101;
    case BROKER_ID_NOT_REGISTERED = 102;
    case INCONSISTENT_TOPIC_ID = 103;
    case INCONSISTENT_CLUSTER_ID = 104;
    case TRANSACTIONAL_ID_NOT_FOUND = 105;
    case FETCH_SESSION_TOPIC_ID_ERROR = 106;
    case INELIGIBLE_REPLICA = 107;
    case NEW_LEADER_ELECTED = 108;

    /**
     * @return non-empty-string
     */
    public function description(): string
    {
        return match ($this) {
            self::UNKNOWN_SERVER_ERROR => 'The server experienced an unexpected error when processing the request.',
            self::NONE => 'No error.',
            self::OFFSET_OUT_OF_RANGE => 'The requested offset is not within the range of offsets maintained by the server.',
            self::CORRUPT_MESSAGE => 'This message has failed its CRC checksum, exceeds the valid size, has a null key for a compacted topic, or is otherwise corrupt.',
            self::UNKNOWN_TOPIC_OR_PARTITION => 'This server does not host this topic-partition.',
            self::INVALID_FETCH_SIZE => 'The requested fetch size is invalid.',
            self::LEADER_NOT_AVAILABLE => 'There is no leader for this topic-partition as we are in the middle of a leadership election.',
            self::NOT_LEADER_OR_FOLLOWER => 'For requests intended only for the leader, this error indicates that the broker is not the current leader. For requests intended for any replica, this error indicates that the broker is not a replica of the topic partition.',
            self::REQUEST_TIMED_OUT => 'The request timed out.',
            self::BROKER_NOT_AVAILABLE => 'The broker is not available.',
            self::REPLICA_NOT_AVAILABLE => 'The replica is not available for the requested topic-partition. Produce/Fetch requests and other requests intended only for the leader or follower return NOT_LEADER_OR_FOLLOWER if the broker is not a replica of the topic-partition.',
            self::MESSAGE_TOO_LARGE => 'The request included a message larger than the max message size the server will accept.',
            self::STALE_CONTROLLER_EPOCH => 'The controller moved to another broker.',
            self::OFFSET_METADATA_TOO_LARGE => 'The metadata field of the offset request was too large.',
            self::NETWORK_EXCEPTION => 'The server disconnected before a response was received.',
            self::COORDINATOR_LOAD_IN_PROGRESS => 'The coordinator is loading and hence can\'t process requests.',
            self::COORDINATOR_NOT_AVAILABLE => 'The coordinator is not available.',
            self::NOT_COORDINATOR => 'This is not the correct coordinator.',
            self::INVALID_TOPIC_EXCEPTION => 'The request attempted to perform an operation on an invalid topic.',
            self::RECORD_LIST_TOO_LARGE => 'The request included message batch larger than the configured segment size on the server.',
            self::NOT_ENOUGH_REPLICAS => 'Messages are rejected since there are fewer in-sync replicas than required.',
            self::NOT_ENOUGH_REPLICAS_AFTER_APPEND => 'Messages are written to the log, but to fewer in-sync replicas than required.',
            self::INVALID_REQUIRED_ACKS => 'Produce request specified an invalid value for required acks.',
            self::ILLEGAL_GENERATION => 'Specified group generation id is not valid.',
            self::INCONSISTENT_GROUP_PROTOCOL => 'The group member\'s supported protocols are incompatible with those of existing members or first group member tried to join with empty protocol type or empty protocol list.',
            self::INVALID_GROUP_ID => 'The configured groupId is invalid.',
            self::UNKNOWN_MEMBER_ID => 'The coordinator is not aware of this member.',
            self::INVALID_SESSION_TIMEOUT => 'The session timeout is not within the range allowed by the broker (as configured by group.min.session.timeout.ms and group.max.session.timeout.ms).',
            self::REBALANCE_IN_PROGRESS => 'The group is rebalancing, so a rejoin is needed.',
            self::INVALID_COMMIT_OFFSET_SIZE => 'The committing offset data size is not valid.',
            self::TOPIC_AUTHORIZATION_FAILED => 'Topic authorization failed.',
            self::GROUP_AUTHORIZATION_FAILED => 'Group authorization failed.',
            self::CLUSTER_AUTHORIZATION_FAILED => 'Cluster authorization failed.',
            self::INVALID_TIMESTAMP => 'The timestamp of the message is out of acceptable range.',
            self::UNSUPPORTED_SASL_MECHANISM => 'The broker does not support the requested SASL mechanism.',
            self::ILLEGAL_SASL_STATE => 'Request is not valid given the current SASL state.',
            self::UNSUPPORTED_VERSION => 'The version of API is not supported.',
            self::TOPIC_ALREADY_EXISTS => 'Topic with this name already exists.',
            self::INVALID_PARTITIONS => 'Number of partitions is below 1.',
            self::INVALID_REPLICATION_FACTOR => 'Replication factor is below 1 or larger than the number of available brokers.',
            self::INVALID_REPLICA_ASSIGNMENT => 'Replica assignment is invalid.',
            self::INVALID_CONFIG => 'Configuration is invalid.',
            self::NOT_CONTROLLER => 'This is not the correct controller for this cluster.',
            self::INVALID_REQUEST => 'This most likely occurs because of a request being malformed by the client library or the message was sent to an incompatible broker. See the broker logs for more details.',
            self::UNSUPPORTED_FOR_MESSAGE_FORMAT => 'The message format version on the broker does not support the request.',
            self::POLICY_VIOLATION => 'Request parameters do not satisfy the configured policy.',
            self::OUT_OF_ORDER_SEQUENCE_NUMBER => 'The broker received an out of order sequence number.',
            self::DUPLICATE_SEQUENCE_NUMBER => 'The broker received a duplicate sequence number.',
            self::INVALID_PRODUCER_EPOCH => 'Producer attempted to produce with an old epoch.',
            self::INVALID_TXN_STATE => 'The producer attempted a transactional operation in an invalid state.',
            self::INVALID_PRODUCER_ID_MAPPING => 'The producer attempted to use a producer id which is not currently assigned to its transactional id.',
            self::INVALID_TRANSACTION_TIMEOUT => 'The transaction timeout is larger than the maximum value allowed by the broker (as configured by transaction.max.timeout.ms).',
            self::CONCURRENT_TRANSACTIONS => 'The producer attempted to update a transaction while another concurrent operation on the same transaction was ongoing.',
            self::TRANSACTION_COORDINATOR_FENCED => 'Indicates that the transaction coordinator sending a WriteTxnMarker is no longer the current coordinator for a given producer.',
            self::TRANSACTIONAL_ID_AUTHORIZATION_FAILED => 'Transactional Id authorization failed.',
            self::SECURITY_DISABLED => 'Security features are disabled.',
            self::OPERATION_NOT_ATTEMPTED => 'The broker did not attempt to execute this operation. This may happen for batched RPCs where some operations in the batch failed, causing the broker to respond without trying the rest.',
            self::KAFKA_STORAGE_ERROR => 'Disk error when trying to access log file on the disk.',
            self::LOG_DIR_NOT_FOUND => 'The user-specified log directory is not found in the broker config.',
            self::SASL_AUTHENTICATION_FAILED => 'SASL Authentication failed.',
            self::UNKNOWN_PRODUCER_ID => 'This exception is raised by the broker if it could not locate the producer metadata associated with the producerId in question. This could happen if, for instance, the producer\'s records were deleted because their retention time had elapsed. Once the last records of the producerId are removed, the producer\'s metadata is removed from the broker, and future appends by the producer will return this exception.',
            self::REASSIGNMENT_IN_PROGRESS => 'A partition reassignment is in progress.',
            self::DELEGATION_TOKEN_AUTH_DISABLED => 'Delegation Token feature is not enabled.',
            self::DELEGATION_TOKEN_NOT_FOUND => 'Delegation Token is not found on server.',
            self::DELEGATION_TOKEN_OWNER_MISMATCH => 'Specified Principal is not valid Owner/Renewer.',
            self::DELEGATION_TOKEN_REQUEST_NOT_ALLOWED => 'Delegation Token requests are not allowed on PLAINTEXT/1-way SSL channels and on delegation token authenticated channels.',
            self::DELEGATION_TOKEN_AUTHORIZATION_FAILED => 'Delegation Token authorization failed.',
            self::DELEGATION_TOKEN_EXPIRED => 'Delegation Token is expired.',
            self::INVALID_PRINCIPAL_TYPE => 'Supplied principalType is not supported.',
            self::NON_EMPTY_GROUP => 'The group is not empty.',
            self::GROUP_ID_NOT_FOUND => 'The group id does not exist.',
            self::FETCH_SESSION_ID_NOT_FOUND => 'The fetch session ID was not found.',
            self::INVALID_FETCH_SESSION_EPOCH => 'The fetch session epoch is invalid.',
            self::LISTENER_NOT_FOUND => 'There is no listener on the leader broker that matches the listener on which metadata request was processed.',
            self::TOPIC_DELETION_DISABLED => 'Topic deletion is disabled.',
            self::FENCED_LEADER_EPOCH => 'The leader epoch in the request is older than the epoch on the broker.',
            self::UNKNOWN_LEADER_EPOCH => 'The leader epoch in the request is newer than the epoch on the broker.',
            self::UNSUPPORTED_COMPRESSION_TYPE => 'The requesting client does not support the compression type of given partition.',
            self::STALE_BROKER_EPOCH => 'Broker epoch has changed.',
            self::OFFSET_NOT_AVAILABLE => 'The leader high watermark has not caught up from a recent leader election so the offsets cannot be guaranteed to be monotonically increasing.',
            self::MEMBER_ID_REQUIRED => 'The group member needs to have a valid member id before actually entering a consumer group.',
            self::PREFERRED_LEADER_NOT_AVAILABLE => 'The preferred leader was not available.',
            self::GROUP_MAX_SIZE_REACHED => 'The consumer group has reached its max size.',
            self::FENCED_INSTANCE_ID => 'The broker rejected this static consumer since another consumer with the same group.instance.id has registered with a different member.id.',
            self::ELIGIBLE_LEADERS_NOT_AVAILABLE => 'Eligible topic partition leaders are not available.',
            self::ELECTION_NOT_NEEDED => 'Leader election not needed for topic partition.',
            self::NO_REASSIGNMENT_IN_PROGRESS => 'No partition reassignment is in progress.',
            self::GROUP_SUBSCRIBED_TO_TOPIC => 'Deleting offsets of a topic is forbidden while the consumer group is actively subscribed to it.',
            self::INVALID_RECORD => 'This record has failed the validation on broker and hence will be rejected.',
            self::UNSTABLE_OFFSET_COMMIT => 'There are unstable offsets that need to be cleared.',
            self::THROTTLING_QUOTA_EXCEEDED => 'The throttling quota has been exceeded.',
            self::PRODUCER_FENCED => 'There is a newer producer with the same transactionalId which fences the current one.',
            self::RESOURCE_NOT_FOUND => 'A request illegally referred to a resource that does not exist.',
            self::DUPLICATE_RESOURCE => 'A request illegally referred to the same resource twice.',
            self::UNACCEPTABLE_CREDENTIAL => 'Requested credential would not meet criteria for acceptability.',
            self::INCONSISTENT_VOTER_SET => 'Indicates that the either the sender or recipient of a voter-only request is not one of the expected voters',
            self::INVALID_UPDATE_VERSION => 'The given update version was invalid.',
            self::FEATURE_UPDATE_FAILED => 'Unable to update finalized features due to an unexpected server error.',
            self::PRINCIPAL_DESERIALIZATION_FAILURE => 'Request principal deserialization failed during forwarding. This indicates an internal error on the broker cluster security setup.',
            self::SNAPSHOT_NOT_FOUND => 'Requested snapshot was not found',
            self::POSITION_OUT_OF_RANGE => 'Requested position is not greater than or equal to zero, and less than the size of the snapshot.',
            self::UNKNOWN_TOPIC_ID => 'This server does not host this topic ID.',
            self::DUPLICATE_BROKER_REGISTRATION => 'This broker ID is already in use.',
            self::BROKER_ID_NOT_REGISTERED => 'The given broker ID was not registered.',
            self::INCONSISTENT_TOPIC_ID => 'The log\'s topic ID did not match the topic ID in the request',
            self::INCONSISTENT_CLUSTER_ID => 'The clusterId in the request does not match that found on the server',
            self::TRANSACTIONAL_ID_NOT_FOUND => 'The transactionalId could not be found',
            self::FETCH_SESSION_TOPIC_ID_ERROR => 'The fetch session encountered inconsistent topic ID usage',
            self::INELIGIBLE_REPLICA => 'The new ISR contains at least one ineligible replica.',
            self::NEW_LEADER_ELECTED => 'The AlterPartition request successfully updated the partition state but the leader has changed.',
        };
    }

    public function retryable(): bool
    {
        return match ($this) {
            self::UNKNOWN_SERVER_ERROR,
            self::NONE,
            self::OFFSET_OUT_OF_RANGE,
            self::INVALID_FETCH_SIZE,
            self::BROKER_NOT_AVAILABLE,
            self::MESSAGE_TOO_LARGE,
            self::STALE_CONTROLLER_EPOCH,
            self::OFFSET_METADATA_TOO_LARGE,
            self::INVALID_TOPIC_EXCEPTION,
            self::RECORD_LIST_TOO_LARGE,
            self::INVALID_REQUIRED_ACKS,
            self::ILLEGAL_GENERATION,
            self::INCONSISTENT_GROUP_PROTOCOL,
            self::INVALID_GROUP_ID,
            self::UNKNOWN_MEMBER_ID,
            self::INVALID_SESSION_TIMEOUT,
            self::REBALANCE_IN_PROGRESS,
            self::INVALID_COMMIT_OFFSET_SIZE,
            self::TOPIC_AUTHORIZATION_FAILED,
            self::GROUP_AUTHORIZATION_FAILED,
            self::CLUSTER_AUTHORIZATION_FAILED,
            self::INVALID_TIMESTAMP,
            self::UNSUPPORTED_SASL_MECHANISM,
            self::ILLEGAL_SASL_STATE,
            self::UNSUPPORTED_VERSION,
            self::TOPIC_ALREADY_EXISTS,
            self::INVALID_PARTITIONS,
            self::INVALID_REPLICATION_FACTOR,
            self::INVALID_REPLICA_ASSIGNMENT,
            self::INVALID_CONFIG,
            self::INVALID_REQUEST,
            self::UNSUPPORTED_FOR_MESSAGE_FORMAT,
            self::POLICY_VIOLATION,
            self::OUT_OF_ORDER_SEQUENCE_NUMBER,
            self::DUPLICATE_SEQUENCE_NUMBER,
            self::INVALID_PRODUCER_EPOCH,
            self::INVALID_TXN_STATE,
            self::INVALID_PRODUCER_ID_MAPPING,
            self::INVALID_TRANSACTION_TIMEOUT,
            self::TRANSACTION_COORDINATOR_FENCED,
            self::TRANSACTIONAL_ID_AUTHORIZATION_FAILED,
            self::SECURITY_DISABLED,
            self::OPERATION_NOT_ATTEMPTED,
            self::LOG_DIR_NOT_FOUND,
            self::SASL_AUTHENTICATION_FAILED,
            self::UNKNOWN_PRODUCER_ID,
            self::REASSIGNMENT_IN_PROGRESS,
            self::DELEGATION_TOKEN_AUTH_DISABLED,
            self::DELEGATION_TOKEN_NOT_FOUND,
            self::DELEGATION_TOKEN_OWNER_MISMATCH,
            self::DELEGATION_TOKEN_REQUEST_NOT_ALLOWED,
            self::DELEGATION_TOKEN_AUTHORIZATION_FAILED,
            self::DELEGATION_TOKEN_EXPIRED,
            self::INVALID_PRINCIPAL_TYPE,
            self::NON_EMPTY_GROUP,
            self::GROUP_ID_NOT_FOUND,
            self::TOPIC_DELETION_DISABLED,
            self::UNSUPPORTED_COMPRESSION_TYPE,
            self::STALE_BROKER_EPOCH,
            self::MEMBER_ID_REQUIRED,
            self::GROUP_MAX_SIZE_REACHED,
            self::FENCED_INSTANCE_ID,
            self::NO_REASSIGNMENT_IN_PROGRESS,
            self::GROUP_SUBSCRIBED_TO_TOPIC,
            self::INVALID_RECORD,
            self::PRODUCER_FENCED,
            self::RESOURCE_NOT_FOUND,
            self::DUPLICATE_RESOURCE,
            self::UNACCEPTABLE_CREDENTIAL,
            self::INCONSISTENT_VOTER_SET,
            self::INVALID_UPDATE_VERSION,
            self::FEATURE_UPDATE_FAILED,
            self::PRINCIPAL_DESERIALIZATION_FAILURE,
            self::SNAPSHOT_NOT_FOUND,
            self::POSITION_OUT_OF_RANGE,
            self::DUPLICATE_BROKER_REGISTRATION,
            self::BROKER_ID_NOT_REGISTERED,
            self::INCONSISTENT_CLUSTER_ID,
            self::TRANSACTIONAL_ID_NOT_FOUND,
            self::INELIGIBLE_REPLICA,
            self::NEW_LEADER_ELECTED => false,
            self::CORRUPT_MESSAGE,
            self::UNKNOWN_TOPIC_OR_PARTITION,
            self::LEADER_NOT_AVAILABLE,
            self::NOT_LEADER_OR_FOLLOWER,
            self::REQUEST_TIMED_OUT,
            self::REPLICA_NOT_AVAILABLE,
            self::NETWORK_EXCEPTION,
            self::COORDINATOR_LOAD_IN_PROGRESS,
            self::COORDINATOR_NOT_AVAILABLE,
            self::NOT_COORDINATOR,
            self::NOT_ENOUGH_REPLICAS,
            self::NOT_ENOUGH_REPLICAS_AFTER_APPEND,
            self::NOT_CONTROLLER,
            self::CONCURRENT_TRANSACTIONS,
            self::KAFKA_STORAGE_ERROR,
            self::FETCH_SESSION_ID_NOT_FOUND,
            self::INVALID_FETCH_SESSION_EPOCH,
            self::LISTENER_NOT_FOUND,
            self::FENCED_LEADER_EPOCH,
            self::UNKNOWN_LEADER_EPOCH,
            self::OFFSET_NOT_AVAILABLE,
            self::PREFERRED_LEADER_NOT_AVAILABLE,
            self::ELIGIBLE_LEADERS_NOT_AVAILABLE,
            self::ELECTION_NOT_NEEDED,
            self::UNSTABLE_OFFSET_COMMIT,
            self::THROTTLING_QUOTA_EXCEEDED,
            self::UNKNOWN_TOPIC_ID,
            self::INCONSISTENT_TOPIC_ID,
            self::FETCH_SESSION_TOPIC_ID_ERROR => true,
        };
    }
}
