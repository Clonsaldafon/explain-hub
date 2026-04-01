<?php

namespace Framework\Tests;

use Framework\Container\Container;
use Framework\Container\ContainerInterface;
use Framework\Container\Exceptions\ContainerException;
use Framework\Container\Exceptions\NotFoundException;

class ContainerTest
{
    public function run()
    {
        echo "Testing DI Container Implementation\n";
        echo "==================================\n\n";

        $container = new Container();

        // Test 1: Basic binding and resolution
        echo "Test 1: Basic binding and resolution\n";
        $container->bind('test.string', 'Hello World!');
        $result = $container->get('test.string');
        echo "Result: " . $result . "\n";
        echo "Expected: Hello World!\n";
        echo "Status: " . ($result === 'Hello World!' ? 'PASS' : 'FAIL') . "\n\n";

        // Test 2: Singleton binding
        echo "Test 2: Singleton binding\n";
        $container->singleton('test.singleton', function() {
            return new \stdClass();
        });

        $singleton1 = $container->get('test.singleton');
        $singleton2 = $container->get('test.singleton');

        echo "Same instance: " . ($singleton1 === $singleton2 ? 'YES' : 'NO') . "\n";
        echo "Status: " . ($singleton1 === $singleton2 ? 'PASS' : 'FAIL') . "\n\n";

        // Test 3: Class resolution with dependencies
        echo "Test 3: Class resolution with dependencies\n";

        class TestDependency {
            public function getMessage() {
                return "Dependency working!";
            }
        }

        class TestService {
            private $dependency;

            public function __construct(TestDependency $dependency) {
                $this->dependency = $dependency;
            }

            public function doSomething() {
                return $this->dependency->getMessage();
            }
        }

        $container->bind(TestDependency::class, TestDependency::class);
        $container->bind(TestService::class, TestService::class);

        $service = $container->get(TestService::class);
        $result = $service->doSomething();

        echo "Result: " . $result . "\n";
        echo "Expected: Dependency working!\n";
        echo "Status: " . ($result === 'Dependency working!' ? 'PASS' : 'FAIL') . "\n\n";

        // Test 4: Exception handling
        echo "Test 4: Exception handling\n";
        try {
            $container->get('non.existent.service');
            echo "Status: FAIL (Expected exception not thrown)\n";
        } catch (NotFoundException $e) {
            echo "Status: PASS (NotFoundException caught)\n";
            echo "Message: " . $e->getMessage() . "\n";
        } catch (\Exception $e) {
            echo "Status: FAIL (Wrong exception type)\n";
        }

        echo "\nAll tests completed!\n";
    }
}

// Run the test
$test = new ContainerTest();
$test->run();