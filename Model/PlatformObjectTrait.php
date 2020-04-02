<?php

namespace Softspring\CustomerBundle\Model;

/**
 * Trait PlatformObjectTrait
 */
trait PlatformObjectTrait
{
    /**
     * @var int|null
     */
    protected $platform;

    /**
     * @var string|null
     */
    protected $platformId;

    /**
     * @var array|null
     */
    protected $platformData;

    /**
     * @var \DateTime|null
     */
    protected $platformLastSync;

    /**
     * @var bool
     */
    protected $platformConflict = false;

    /**
     * @var bool
     */
    protected $testMode = false;

    /**
     * @return int|null
     */
    public function getPlatform(): ?int
    {
        return $this->platform;
    }

    /**
     * @param int|null $platform
     */
    public function setPlatform(?int $platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @return string|null
     */
    public function getPlatformId(): ?string
    {
        return $this->platformId;
    }

    /**
     * @param string|null $platformId
     */
    public function setPlatformId(?string $platformId): void
    {
        $this->platformId = $platformId;
    }

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     */
    public function setTestMode(bool $testMode): void
    {
        $this->testMode = $testMode;
    }

    /**
     * @return array|null
     */
    public function getPlatformData(): ?array
    {
        return $this->platformData;
    }

    /**
     * @param array|null $platformData
     */
    public function setPlatformData(?array $platformData): void
    {
        $this->platformData = $platformData;
    }

    /**
     * @return \DateTime|null
     */
    public function getPlatformLastSync(): ?\DateTime
    {
        return $this->platformLastSync ? \DateTime::createFromFormat('U', $this->platformLastSync) : null;
    }

    /**
     * @param \DateTime|null $platformLastSync
     */
    public function setPlatformLastSync(?\DateTime $platformLastSync): void
    {
        $this->platformLastSync = $platformLastSync instanceof \DateTime ? $platformLastSync->format('U') : null;
    }

    /**
     * @return bool
     */
    public function isPlatformConflict(): bool
    {
        return $this->platformConflict;
    }

    /**
     * @param bool $platformConflict
     */
    public function setPlatformConflict(bool $platformConflict): void
    {
        $this->platformConflict = $platformConflict;
    }
}