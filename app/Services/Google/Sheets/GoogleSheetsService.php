<?php

namespace App\Services\Google\Sheets;

use Exception;
use Google\Service\Exception as BaseGoogleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;
use Revolution\Google\Sheets\SheetsClient;

final readonly class GoogleSheetsService
{
    public function __construct(
        protected string $spreadsheetId,
        protected string $sheetName,
        protected string $range,
    ) {
    }

    /**
     * @throws GoogleSheetsException
     */
    public function get(): Collection
    {
        try {
            $response = $this->getSheets()->get();
        } catch (BaseGoogleException $exception) {
            throw GoogleSheetsException::fromGoogleException(
                exception: $exception,
            );
        } catch (Exception $exception) {
            throw GoogleSheetsException::fromNonGoogleException(
                exception: $exception,
            );
        }

        return $response;
    }

    /**
     * @throws GoogleSheetsException
     */
    public function append(array $data): array
    {
        try {
            $response = $this->getSheets()->append(
                values: [$data],
            );
        } catch (BaseGoogleException $exception) {
            throw GoogleSheetsException::fromGoogleException(
                exception: $exception,
            );
        }

        $updatedRange = Str::of(
            string: $response->getUpdates()->getUpdatedRange(),
        );

        return [
            'range' => $updatedRange->after(
                search: '!',
            ),
            'row' =>  $updatedRange->match(
                pattern: '/![A-Z](\d+)/',
            ),
        ];
    }

    /**
     * @throws GoogleSheetsException
     */
    public function update(array $data): void
    {
        try {
            $this->getSheets()->update(
                value: [$data],
            );
        } catch (BaseGoogleException $exception) {
            throw GoogleSheetsException::fromGoogleException(
                exception: $exception,
            );
        }
    }

    protected function getSheets()
    {
        return Sheets::spreadsheet(
            spreadsheetId: $this->spreadsheetId
        )->sheet(
            sheet: $this->sheetName
        )->range(
            range: $this->range
        );
    }
}
