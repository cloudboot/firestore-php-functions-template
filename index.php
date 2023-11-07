<?php
use CloudEvents\V1\CloudEventInterface;
use Google\CloudFunctions\FunctionsFramework;

// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=cloudevent` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.
FunctionsFramework::cloudEvent('main', 'main');

function main(CloudEventInterface $event): void
{
  $data = $event->getData();
  $bucketName = $data['resource']['labels']['bucket_name'] ?? '[NO BUCKET]';
  $log = fopen(getenv('LOGGER_OUTPUT') ?: 'php://stdout', 'wb');
  fwrite($log, "Received event from $bucketName!" . PHP_EOL);
}
