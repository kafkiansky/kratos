<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

/**
 * @phpst
 */
enum ApiKey: int
{
    case PRODUCE = 0;
    case FETCH = 1;
    case LIST_OFFSETS = 2;
    case METADATA = 3;
    case LEADER_AND_ISR = 4;
    case STOP_REPLICA = 5;
    case UPDATE_METADATA = 6;
    case CONTROLLED_SHUTDOWN = 7;
    case OFFSET_COMMIT = 8;
    case OFFSET_FETCH = 9;
    case FIND_COORDINATOR = 10;
    case JOIN_GROUP = 11;
    case HEARTBEAT = 12;
    case LEAVE_GROUP = 13;
    case SYNC_GROUP = 14;
    case DESCRIBE_GROUPS = 15;
    case LIST_GROUPS = 16;
    case SASL_HANDSHAKE = 17;
    case API_VERSIONS = 18;
    case CREATE_TOPICS = 19;
    case DELETE_TOPICS = 20;
    case DELETE_RECORDS = 21;
    case INIT_PRODUCER_ID = 22;
    case OFFSET_FOR_LEADER_EPOCH = 23;
    case ADD_PARTITIONS_TO_TXN = 24;
    case ADD_OFFSETS_TO_TXN = 25;
    case END_TXN = 26;
    case WRITE_TXN_MARKERS = 27;
    case TXN_OFFSET_COMMIT = 28;
    case DESCRIBE_ACLS = 29;
    case CREATE_ACLS = 30;
    case DELETE_ACLS = 31;
    case DESCRIBE_CONFIGS = 32;
    case ALTER_CONFIGS = 33;
    case ALTER_REPLICA_LOG_DIRS = 34;
    case DESCRIBE_LOG_DIRS = 35;
    case SASL_AUTHENTICATE = 36;
    case CREATE_PARTITIONS = 37;
    case CREATE_DELEGATION_TOKEN = 38;
    case RENEW_DELEGATION_TOKEN = 39;
    case EXPIRE_DELEGATION_TOKEN = 40;
    case DESCRIBE_DELEGATION_TOKEN = 41;
    case DELETE_GROUPS = 42;
    case ELECT_LEADERS = 43;
    case INCREMENTAL_ALTER_CONFIGS = 44;
    case ALTER_PARTITION_REASSIGNMENTS = 45;
    case LIST_PARTITION_REASSIGNMENTS = 46;
    case OFFSET_DELETE = 47;
    case DESCRIBE_CLIENT_QUOTAS = 48;
    case ALTER_CLIENT_QUOTAS = 49;
    case DESCRIBE_USER_SCRAM_CREDENTIALS = 50;
    case ALTER_USER_SCRAM_CREDENTIALS = 51;
    case DESCRIBE_QUORUM = 55;
    case ALTER_PARTITION = 56;
    case UPDATE_FEATURES = 57;
    case ENVELOPE = 58;
    case DESCRIBE_CLUSTER = 60;
    case DESCRIBE_PRODUCERS = 61;
    case UNREGISTER_BROKER = 64;
    case DESCRIBE_TRANSACTIONS = 65;
    case LIST_TRANSACTIONS = 66;
    case ALLOCATE_PRODUCER_IDS = 67;
    case CONSUMER_GROUP_HEARTBEAT = 68;
    case CONSUMER_GROUP_DESCRIBE = 69;
    case GET_TELEMETRY_SUBSCRIPTIONS = 71;
    case PUSH_TELEMETRY = 72;
    case LIST_CLIENT_METRICS_RESOURCES = 74;
}
