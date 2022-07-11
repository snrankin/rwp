<?php

namespace RWP\Vendor\PUC\v4p11\Vcs;

interface BaseChecker{
	/**
	 * Set the repository branch to use for updates. Defaults to 'master'.
	 *
	 * @param string $branch
	 * @return $this
	 */
	public function setBranch($branch);
	/**
	 * Set authentication credentials.
	 *
	 * @param array|string $credentials
	 * @return $this
	 */
	public function setAuthentication($credentials);
	/**
	 * @return Api
	 */
	public function getVcsApi();
}
