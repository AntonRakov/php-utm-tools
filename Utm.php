<?php

use AntonRakov\Utm\NotAllowedKeyException;

/**
 * Utm-labels tool
 *
 * @package AntonRakov\Utm
 */
class Utm
{
    /**
     * Storage for GET-parameters
     *
     * @var string[]
     */
    protected array $getParams = [];

    /**
     * Allowed utm-labels
     *
     * @var string[]
     */
    protected array $allowedLabels = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term'
    ];

    /**
     * Storage for utm-labels
     *
     * @var string[]
     */
    protected array $utmLabels = [];

    /**
     * Recording utm-labels in cookies
     *
     * @param array $getParams
     * @return bool
     */
    public function set(array $getParams): bool
    {
        $this->getParams = $getParams;
        $this->clearParams();

        $successSave = true;
        foreach ($this->utmLabels as $utmLabelKey => $utmLabelValue) {
            if (!setcookie($utmLabelKey, $utmLabelValue)) {
                $successSave = false;
            }
        }

        return $successSave;
    }

    /**
     * Filtering and clearing GET-parameters with subsequent recording
     *
     * @return void
     */
    protected function clearParams(): void
    {
        foreach ($this->allowedLabels as $label) {
            if (!empty($this->getParams[$label])) {
                $utmLabel = $this->getParams[$label];
                $utmLabel = strval($utmLabel);
                $utmLabel = stripslashes($utmLabel);
                $utmLabel = htmlspecialchars_decode($utmLabel, ENT_QUOTES);
                $utmLabel = strip_tags($utmLabel);
                $utmLabel = htmlspecialchars($utmLabel, ENT_QUOTES);
                $this->utmLabels[$label] = $utmLabel;
            }
        }
    }

    /**
     * Getting utm-labels from cookies
     *
     * @return string[]
     */
    public function get(): array
    {
        foreach ($_COOKIE as $cookieKey => $cookieValue) {
            if (in_array($cookieKey, $this->allowedLabels)) {
                $this->utmLabels[$cookieKey] = $cookieValue;
            }
        }
        $this->clearParams();

        return $this->utmLabels;
    }

    /**
     * Getting utm tags from cookies by code
     *
     * @param string $code
     * @return string
     * @throws NotAllowedKeyException
     */
    public function getUtmValueByCode(string $code): string
    {
        $this->get();

        if (array_key_exists($code, $this->utmLabels)) {
            return $this->utmLabels[$code];
        } else {
            throw new NotAllowedKeyException();
        }
    }
}
