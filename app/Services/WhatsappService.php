<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Throwable;

class WhatsappService
{
    protected string $baseUrl;
    protected int $timeout = 15;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('app.whatsapp_api_url'), '/');

        Log::info('[WA][INIT] Service initialized', [
            'base_url' => $this->baseUrl,
            'timeout'  => $this->timeout,
        ]);
    }

    /**
     * SEND TEXT MESSAGE
     */
    public function sendText(
        string $waSessionId,
        string $number,
        string $message
    ): bool {
        $endpoint = $this->baseUrl . '/send-message';

        $payload = [
            'wa_session_id' => $waSessionId,
            'number'        => $number,
            'message'       => $message,
        ];

        Log::info('[WA][TEXT][REQUEST]', [
            'endpoint'        => $endpoint,
            'wa_session_id'   => $waSessionId,
            'number'          => $number,
            'message_length'  => strlen($message),
        ]);

        try {
            $response = Http::timeout($this->timeout)
                ->asForm()
                ->post($endpoint, $payload);

            $this->logResponse('TEXT', $number, $response);

            if (!$response->successful()) {
                Log::error('[WA][TEXT][FAILED]', [
                    'wa_session_id' => $waSessionId,
                    'number'        => $number,
                    'status'        => $response->status(),
                    'body'          => $this->safeBody($response),
                ]);
                return false;
            }

            Log::info('[WA][TEXT][SUCCESS]', [
                'wa_session_id' => $waSessionId,
                'number'        => $number,
            ]);

            return true;
        } catch (Throwable $e) {
            $this->logException('TEXT', $waSessionId, $number, $e);
            return false;
        }
    }

    /**
     * SEND IMAGE / ATTACHMENT
     */
    public function sendWithAttachment(
        string $waSessionId,
        string $number,
        string $caption,
        string $filePath
    ): bool {
        $endpoint = $this->baseUrl . '/send-message-image';

        Log::info('[WA][IMAGE][REQUEST]', [
            'endpoint'       => $endpoint,
            'wa_session_id'  => $waSessionId,
            'number'         => $number,
            'file_path'      => $filePath,
            'exists'         => file_exists($filePath),
        ]);

        if (!file_exists($filePath)) {
            Log::warning('[WA][IMAGE][FILE_NOT_FOUND]', [
                'file_path' => $filePath,
            ]);
            return false;
        }

        try {
            $response = Http::timeout(30)
                ->asMultipart()
                ->attach(
                    'file',
                    file_get_contents($filePath),
                    basename($filePath)
                )
                ->post($endpoint, [
                    'wa_session_id' => $waSessionId,
                    'number'        => $number,
                    'caption'       => $caption,
                ]);

            $this->logResponse('IMAGE', $number, $response);

            if (!$response->successful()) {
                Log::error('[WA][IMAGE][FAILED]', [
                    'wa_session_id' => $waSessionId,
                    'number'        => $number,
                    'status'        => $response->status(),
                    'body'          => $this->safeBody($response),
                ]);
                return false;
            }

            Log::info('[WA][IMAGE][SUCCESS]', [
                'wa_session_id' => $waSessionId,
                'number'        => $number,
                'file'          => basename($filePath),
            ]);

            return true;
        } catch (Throwable $e) {
            $this->logException('IMAGE', $waSessionId, $number, $e);
            return false;
        }
    }

    /**
     * LOG RESPONSE
     */
    protected function logResponse(
        string $type,
        string $number,
        Response $response
    ): void {
        Log::info("[WA][$type][RESPONSE]", [
            'number'  => $number,
            'status'  => $response->status(),
            'body'    => $this->safeBody($response),
        ]);
    }

    /**
     * LOG EXCEPTION
     */
    protected function logException(
        string $type,
        string $waSessionId,
        string $number,
        Throwable $e
    ): void {
        Log::critical("[WA][$type][EXCEPTION]", [
            'wa_session_id' => $waSessionId,
            'number'        => $number,
            'error'         => $e->getMessage(),
            'file'          => $e->getFile(),
            'line'          => $e->getLine(),
        ]);
    }

    protected function safeBody(Response $response): string
    {
        $body = $response->body();

        return strlen($body) > 2000
            ? substr($body, 0, 2000) . '... [TRUNCATED]'
            : $body;
    }
}
